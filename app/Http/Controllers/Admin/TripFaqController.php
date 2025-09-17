<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Models\Trip;
use App\Models\TripFaq;
use Illuminate\Http\Request;

class TripFaqController extends Controller
{
    public function index()
    {
        return view('admin.tripFaqs.index');
    }

    public function create(?Trip $trip=null)
    {
        return view('admin.tripFaqs.add', [
			'trips' => Trip::all(),
			'currentTrip' => $trip,
			'faqCategories' => FaqCategory::all()
		]);
    }

    public function faqList($tripId)
    {
        return response()->json([
            'data' => TripFaq::where('trip_id', '=', $tripId)->with('faqCategory')->get(),
        ]);
    }

    public function faqs($tripId)
    {
        $trip = Trip::find($tripId);

        return view('admin.tripFaqs.faqs-list', compact('trip'));
    }

    public function tripList()
    {
        return response()->json([
            'data' => Trip::whereHas('trip_faqs')->withCount('trip_faqs')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $status = 0;
        $msg = '';
        $trip_faq = new TripFaq;
        $trip_faq->trip_id = $request->trip_id;
        $trip_faq->title = $request->title;
		$trip_faq->faq_category_id = $request->faq_category_id;
        $trip_faq->description = $request->description;

        $trip_faq->save();

        return response()->json([
            'status' => 1,
            'message' => 'Trip faq created!',
        ]);
    }

    public function edit($id)
	{
		$trip_faq = TripFaq::findOrFail($id);
		$trip_faq->load('faqCategory');

		return view('admin.tripFaqs.edit', [
			'trip_faq' => $trip_faq,
			'trips' => Trip::all(),
			'faqCategories' => FaqCategory::all()
		]);
	}

    public function update(Request $request)
    {
        $trip_faq = TripFaq::find($request->id);
        $trip_faq->trip_id = $request->trip_id;
		$trip_faq->faq_category_id = $request->faq_category_id;
        $trip_faq->title = $request->title;
        $trip_faq->description = $request->description;
        $trip_faq->save();

        return response()->json([
            'status' => 1,
            'message' => 'Trip faq updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $status = 0;
        $http_status_code = 400;
        $msg = '';
        $path = 'public/trip-faqs/';

        if (TripFaq::find($id)->delete()) {
            $status = 1;
            $http_status_code = 200;
            $msg = 'Trip faq has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }

    public function destroyAllTripFaqs($tripId)
    {
        $status = 0;
        $http_status_code = 404;
        $msg = '';

        if (TripFaq::where('trip_id', '=', $tripId)->delete()) {
            $status = 1;
            $http_status_code = 200;
            $msg = 'All trip faqs has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }

    public function publish($id)
    {
        $success = false;
        $message = '';

        $trip_faq = TripFaq::find($id);

        if ($trip_faq) {
            if ($trip_faq->status == 1) {
                $trip_faq->status = 0;
            } else {
                $trip_faq->status = 1;
            }

            if ($trip_faq->save()) {
                $message = 'Review has been published.';
                $success = true;
            }

        } else {
            $message = __('alerts.not_found_error');
        }

        return response()->json([
            'data' => [],
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function updateCategory(Request $request, $id)
	{
		$success = false;
		$message = "";

		$faq = TripFaq::find($id);
		$faq->faq_category_id = $request->category_id;
		if ($faq->save()) {
			$success = true;
			$message = "Category updated successfully.";
		}

		return response()->json([
			'data' => (object) [],
			'success' => $success,
			'message' => $message
		]);
	}
}
