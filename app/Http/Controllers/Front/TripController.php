<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Setting;
use App\Http\Controllers\Controller;
use App\Mail\BookingCreated;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\TripDeparture;
use App\Models\WhyChoose;
use App\Services\Recaptcha\RecaptchaService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TripController extends Controller
{
    private $page_limit = 6;

    public function index(Request $request): View | JsonResponse {
        if(! $request->ajax()) {
            return view('front.trips.index');
        }
        
        $keyword = $request->string('keyword');
        $activitySlugs = $request->activities ? explode(',',  $request->activities) : [];
        $destinationSlugs = $request->destinations ? explode(',', $request->destinations) : [];
        $regionSlugs = $request->regions ? explode(',', $request->regions) : [];
        $difficultySlugs = $request->difficulties ? explode(',', $request->difficulties) : [];
        $difficulties = array_map(fn($item) => \App\Enums\Difficulty::{str($item)->title()->toString()}->value, $difficultySlugs);
        $duration = $request->duration ? explode('-', $request->duration) : [];
        $price = $request->price ? explode('-', $request->price) : [];

        $query = Trip::select('id', 'name', 'slug', 'duration', 'difficulty_grade', 'cost', 'offer_price');

        if ($keyword) {
            $query->whereLike('name', '%' . $keyword . '%');
        }

        if (!empty($activitySlugs)) {
            $query->whereHas('activities', function ($q) use ($activitySlugs) {
                $q->whereIn('activities.slug', $activitySlugs);
            });
        }

        if (!empty($destinationSlugs)) {
            $query->whereHas('destinations', function ($q) use ($destinationSlugs) {
                $q->whereIn('destinations.slug', $destinationSlugs);
            });
        }

        if (!empty($regionSlugs)) {
            $query->whereHas('regions', function ($q) use ($regionSlugs) {
                $q->whereIn('regions.slug', $regionSlugs);
            });
        }

        if (!empty($difficulties)) {
            $query->whereIn('difficulty_grade', $difficulties);
        }

        if (!empty($duration) && count($duration) === 2) {
            if (!$duration[0]) {
                $query->where('duration', '<=', (int) $duration[1]);
            } elseif (!$duration[1]) {
                $query->where('duration', '>=', (int) $duration[0]);
            } else {
                $query->whereBetween('duration', [(int) $duration[0], (int) $duration[1]]);
            }
        }

        if (!empty($price) && count($price) === 2) {
            if (!$price[0]) {
                $query->where('cost', '<=', (int) $price[1]);
            } elseif (!$price[1]) {
                $query->where('cost', '>=', (int) $price[0]);
            } else {
                $query->whereBetween('cost', [(int) $price[0], (int) $price[1]]);
            }
        }

        $trips = $query->with('trip_galleries')->get()->map(fn($trip) => [
            'slug' => $trip->slug,
            'name' => $trip->name,
            'duration' => $trip->duration,
            'cost' => $trip->cost,
            'offer_price' => $trip->offer_price,
            'imageUrl' => $trip->mediumImageUrl,
            'reviews_count' => $trip->trip_reviews->count(),
            'avg_rating' => $trip->trip_reviews->avg('rating'),
            'link' => $trip->link,
            'difficulty' => $trip->difficulty,
        ])->toArray();

        return response()->json($trips);
    }

    public function show(Trip $trip)
    {
        $trip->load([
            'trip_galleries',
            'trip_sliders',
            'trip_info',
            'trip_include_exclude',
            'trip_itineraries' => function ($q) {
                $q->orderBy('day', 'asc');
            },
            'trip_reviews',
            'similar_trips',
            'addon_trips',
            'trip_seo',
            'trip_departures' => function ($q) {
                $q->where([
                    ['status', 1],
                    ['from_date', '>=', Carbon::today()],
                ])->orderBy('from_date', 'ASC');
            },
        ]);

        $tripFaqs = $trip->trip_faqs()->get()->sortBy('faqCategory.order')->groupBy('faqCategory.id');
        $canMakeChart = true;

        $itineraries = unserialize(serialize($trip->trip_itineraries));
        $itineraries->pop();
        $elevations = $itineraries->map(function ($day) use (&$canMakeChart) {
            if (! is_numeric($day->max_altitude)) {
                $canMakeChart = false;
            }

            return [
                'place_name' => $day->place ?? 'Day '.$day->day,
                'title' => $day->name,
                'max_altitude' => $day->max_altitude,
            ];
        })->toArray();

        $why_choose_us = WhyChoose::select('id', 'title')->latest()->get();
        $blogs = Blog::select('id', 'name', 'slug')->latest()->limit(5)->get();

        return view('front.trips.show', compact('trip', 'tripFaqs', 'blogs', 'why_choose_us', 'canMakeChart', 'elevations'));

    }

    public function booking(Trip $trip)
    {
        $date = request('date') ? date('Y-m-d', request('date')) : null;

        $price_ranges = $trip->people_price_range;

        return view('front.trips.booking', compact('trip', 'date', 'price_ranges'));
    }

    public function departureBooking(Trip $trip, $departureId)
    {
        $trip_departure = TripDeparture::findOrFail($departureId);

        return view('front.trips.departure-booking', compact('trip', 'trip_departure'));
    }

    public function search(Request $request)
    {
        $keyword = $request->q;
        $destination_ids = $request->dest;
        $activity_ids = $request->act;
        $sortBy = $request->price;

        $query = Trip::query();

        if (isset($keyword) && ! empty($keyword)) {
            $query->where([
                ['name', 'LIKE', '%'.$keyword.'%'],
            ]);
        } else {
            if ($destination_ids) {
                $destination_ids = explode(',', $request->dest);
                $query->whereHas('destination', function ($q) use ($destination_ids) {
                    $q->whereIn('destinations.id', $destination_ids);
                });
            }

            if ($activity_ids) {
                $activity_ids = explode(',', $request->act);
                $query->whereHas('activities', function ($q) use ($activity_ids) {
                    $q->whereIn('activities.id', $activity_ids);
                });
            }

            if ($sortBy) {
                if ($sortBy == 'price_l_h') {
                    $query->orderBy('offer_price', 'ASC');
                } else {
                    $query->orderBy('offer_price', 'DESC');
                }
            }
        }

        $trips = $query->latest()->get();

        $destinations = \App\Models\Destination::where('status', '=', 1)->get();
        $activities = \App\Models\Activity::where('status', '=', 1)->get();

        return view('front.trips.search', compact('destinations', 'activities', 'trips'));
    }

    public function searchAjax(Request $request)
    {
        $success = false;
        $message = '';
        $keyword = $request->keyword;
        $query = Trip::query();

        if (isset($keyword) && ! empty($keyword)) {
            $query->where([
                ['name', 'LIKE', '%'.$keyword.'%'],
            ]);
        }

        $trips = $query->select('name', 'slug')->orderBy('name', 'asc')->get();
        if ($trips) {
            $success = true;
            $message = 'List fetched successfully.';
        }

        return response()->json([
            'data' => $trips,
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function filter(Request $request)
    {
        $keyword = $request->keyword;
        $destination_id = $request->destination_id;
        $activity_id = $request->activity_id;
        $sortBy = $request->sortBy;
        $duration = explode(',', $request->duration);
        $price = explode(',', $request->price);
        $region_id = $request->region_id;
        $query = Trip::query();

        if (isset($keyword) && ! empty($keyword)) {
            $query->where([
                ['name', 'LIKE', '%'.$keyword.'%'],
            ]);
        }

        if (isset($duration) && count($duration) === 2) {
            $query->whereRaw('CAST(duration AS UNSIGNED) BETWEEN ? AND ?', [$duration[0], $duration[1]]);
        }

        if (isset($price) && count($price) === 2) {
            $minValue = $price[0];
            $maxValue = $price[1];

            $query->where(function ($query) use ($minValue, $maxValue) {
                $query->where(function ($query) use ($minValue, $maxValue) {
                    $query->whereRaw('IF(offer_price IS NULL OR offer_price = 0, cost, offer_price) BETWEEN ? AND ?', [$minValue, $maxValue]);
                })
                    ->orWhere(function ($query) use ($minValue) {
                        if ($minValue == 0) {
                            $query->whereNull('cost')
                                ->whereNull('offer_price');
                        }
                    });
            });
        }

        if (isset($region_id) && ! empty($region_id)) {
            $query->whereHas('region', function ($q) use ($region_id) {
                $q->where('regions.id', '=', $region_id);
            });
        }

        if (isset($destination_id) && ! empty($destination_id)) {
            $query->whereHas('destination', function ($q) use ($destination_id) {
                $q->where('destinations.id', '=', $destination_id);
            });
        }

        if (isset($activity_id) && ! empty($activity_id)) {
            $query->whereHas('activities', function ($q) use ($activity_id) {
                $q->where('activities.id', '=', $activity_id);
            });
        }

        if (isset($sortBy) && ! empty($sortBy)) {
            $query->orderBy('offer_price', $sortBy);
        }

        $trips = $query->paginate($this->page_limit);
        $html = '';
        if (! empty($trips)) {
            foreach ($trips as $trip) {
                $html .= view('front.elements.tour-card')->with(['tour' => $trip])->render();
            }
        }

        return response()->json([
            'data' => $html,
            'pagination' => [
                'current_page' => $trips->currentPage(),
                'next_page' => $trips->nextPageUrl() ? true : false,
                'total' => $trips->total(),
            ],
            'success' => true,
            'message' => 'List fetched',
        ]);
    }

    public function bookingStore(Request $request, Trip $trip)
    {
        $verifiedRecaptcha = RecaptchaService::verifyRecaptcha($request->get('g-recaptcha-response'));

        if (! $verifiedRecaptcha) {
            session()->flash('error_message', 'Recaptcha error.');

            return redirect()->back();
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'country' => 'required|string|max:255',
            'message' => 'string|nullable',
            'gender' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'no_of_travelers' => 'required|integer',
            'tnc' => 'accepted',
            'pay' => 'required|string',
        ], [
            'tnc.accepted' => 'Please accept our terms and conditions.',
        ]);

        $start_date = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['start_date'])->addDays($trip->duration - 1);
        $price = 0;
        if ($trip->people_price_range) {
            foreach ($trip->people_price_range as $priceItem) {
                if ($priceItem['from'] <= $validated['no_of_travelers'] && $priceItem['to'] >= $validated['no_of_travelers']) {
                    $price = $priceItem['price'];
                    break;
                }
            }
        } else {
            $price = $trip->offer_price;
        }
        $price = $price * $validated['no_of_travelers'];

        $booking = Booking::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'gender' => $validated['gender'],
            'country' => $validated['country'],
            'message' => $validated['message'],
            'amount' => $price,
            'pay' => $validated['pay'],
            'type' => 'private',
        ]);

        $booking->trips()->attach($trip, [
            'no_of_travelers' => $validated['no_of_travelers'],
            'start_date' => $start_date,
            'end_date' => $endDate,
            'price' => $price,
        ]);

        Mail::to(Setting::get('email'))->send(new BookingCreated($booking));

        return back()->with('success_message', 'Booking created successfully.');
    }

    public function departureBookingStore(Request $request)
    {
        $verifiedRecaptcha = RecaptchaService::verifyRecaptcha($request->get('g-recaptcha-response'));

        if (! $verifiedRecaptcha) {
            session()->flash('error_message', 'Recaptcha error.');

            return redirect()->back();
        }
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'country' => 'required|string|max:255',
            'message' => 'string|nullable',
            'gender' => 'nullable|string|max:255',
            'no_of_travelers' => 'required|integer',
            'tnc' => 'accepted',
            'pay' => 'required|string',
        ], [
            'tnc.accepted' => 'Please accept our terms and conditions.',
        ]);

        $request->validate([
            'departure_id' => 'required',
        ]);

        $trip = Trip::select('id', 'name', 'slug')->find($request->id);
        $departure = \App\Models\TripDeparture::find($request->departure_id);

        $booking = Booking::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'gender' => $validated['gender'],
            'country' => $validated['country'],
            'message' => $validated['message'],
            'amount' => $departure->price * $validated['no_of_travelers'],
            'pay' => $validated['pay'],
            'type' => 'fixed',
        ]);

        $start_date = Carbon::parse($departure->from_date);
        $endDate = Carbon::parse($departure->to_date);

        $booking->trips()->attach($trip, [
            'no_of_travelers' => $validated['no_of_travelers'],
            'start_date' => $start_date,
            'end_date' => $endDate,
            'price' => $departure->price * $validated['no_of_travelers'],
        ]);

        Mail::to(Setting::get('email'))->send(new BookingCreated($booking));

        return back()->with('success_message', 'Booking created successfully.');
    }

    public function customizeStore(Request $request)
    {
        $trip = Trip::find($request->id);
        $request->merge([
            'trip' => $trip,
            'ip_address' => $request->ip(),
        ]);

        try {
            Mail::send('emails.customize-trip', ['body' => $request], function ($message) use ($request) {
                $message->to(Setting::get('email'));
                $message->from($request->email);
                $message->subject('Customized Trip');
            });
            session()->flash('success_message', "Thank you for your enquiry. We'll contact you very soon.");

            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            session()->flash('error_message', __('alerts.save_error'));

            return redirect()->back();
        }
    }

    public function customize($slug)
    {
        $trip = Trip::where('slug', '=', $slug)->firstOrFail();

        return view('front.trips.customize-trip', compact('trip'));
    }

    public function allTripGallery()
    {
        $trips = Trip::all();

        return view('front.galleries.index', compact('trips'));
    }

    public function gallery($slug)
    {
        $trip = Trip::where('slug', '=', $slug)->with('trip_galleries')->firstOrFail();

        return view('front.trips.gallery', compact('trip'));
    }

    public function print($slug)
    {
        $trip = Trip::where('slug', '=', $slug)->with('trip_include_exclude', 'trip_itineraries', 'trip_info')->firstOrFail();

        return view('front.trips.print', compact('trip'));
    }
}
