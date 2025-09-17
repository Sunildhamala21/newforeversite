<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Setting;
use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PlanTripController extends Controller
{
    public function index()
    {
        $destinations = Destination::has('trips')->get();

        return view('front.trips.plan', compact('destinations'));
    }

    public function store(Request $request)
    {
        $destinations = Destination::select('name', 'slug')->where('id', $request->destination)->pluck('name');
        $destinations = implode(', ', $destinations->toArray());
        $trips = Trip::select('name', 'slug')->where('id', $request->trip_interested)->pluck('name');
        $trips = implode(', ', $trips->toArray());
        Mail::send('emails.plan-trip', ['body' => $request, 'destinations' => $destinations, 'trips' => $trips], function ($message) use ($request) {
            $message->to(Setting::get('email'));
            $message->from($request->email);
            $message->subject('Enquiry');
        });

        return response()->json([
            'status' => 1,
        ]);
    }

    public function createForTrip($slug)
    {
        $trip = Trip::where('slug', $slug)->with('destinations')->firstOrFail();
        $selected_destinations = $trip->destinations()->get()->pluck('id');
        $destinations = Destination::has('trips')->get();

        return view('front.trips.plan', compact('trip', 'destinations', 'selected_destinations'));
    }

    public function thankYou()
    {
        return view('front.trips.plan-thanks');
    }
}
