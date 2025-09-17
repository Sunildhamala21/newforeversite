<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TripReview;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TripReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = TripReview::get()->toArray();

        return view('admin.tripReviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trips = \App\Models\Trip::all();

        return view('admin.tripReviews.add', compact('trips'));
    }

    public function reviewsList()
    {
        $reviews = TripReview::all();

        return response()->json([
            'data' => $reviews,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'file' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:10000',
        ]);

        $status = 0;
        $msg = '';
        $trip_review = new TripReview;
        $trip_review->trip_id = $request->trip_id;
        $trip_review->title = $request->title;
        $trip_review->review_name = $request->review_name;
        $trip_review->review = $request->review;
        $trip_review->review_country = $request->review_country;
        $trip_review->rating = $request->rating;

        if ($request->hasFile('file')) {
            $trip_review->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($trip_review->save()) {
            if ($request->hasFile('file')) {
                $imageService->processAndStoreImage(
                    $request->file,
                    $trip_review,
                    $trip_review->image_name,
                    'public/trip-reviews/'.$trip_review->id.'/',
                    json_decode($request->cropped_data, true)
                );
                $status = 1;
            }
            $status = 1;
            $msg = 'Trip review created successfully.';
            session()->flash('message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trip_review = TripReview::find($id);

        $trips = \App\Models\Trip::all();

        return view('admin.tripReviews.edit', compact('trip_review', 'trips'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'file' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:10000',
        ]);

        $status = 0;
        $msg = '';
        $trip_review = TripReview::find($request->id);
        $trip_review->trip_id = $request->trip_id;
        $trip_review->title = $request->title;
        $trip_review->review_name = $request->review_name;
        $trip_review->review = $request->review;
        $trip_review->review_country = $request->review_country;
        $trip_review->rating = $request->rating;

        if ($request->hasFile('file')) {
            $trip_review->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($trip_review->save()) {
            // save image.
            if ($request->hasFile('file')) {
                Storage::deleteDirectory('public/trip-reviews/'.$trip_review['id']);
                $imageService->processAndStoreImage(
                    $request->file,
                    $trip_review,
                    $trip_review->image_name,
                    'public/trip-reviews/'.$trip_review->id.'/',
                    json_decode($request->cropped_data, true)
                );
            } else {
                if (! empty($request->cropped_data)) {
                    $imageService->processAndStoreImage(
                        Storage::get('public/trip-reviews/'.$trip_review['id'].'/'.$trip_review->image_name),
                        $trip_review,
                        $trip_review->image_name,
                        'public/trip-reviews/'.$trip_review->id.'/',
                        json_decode($request->cropped_data, true)
                    );
                }
            }
            $status = 1;
            $msg = 'Trip review updated successfully.';
            session()->flash('message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = 0;
        $http_status_code = 400;
        $msg = '';
        $path = 'public/trip-reviews/';

        if (TripReview::find($id)->delete()) {
            Storage::deleteDirectory($path.$id);
            $status = 1;
            $http_status_code = 200;
            $msg = 'Trip review has been deleted';
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

        $trip_review = TripReview::find($id);

        if ($trip_review) {
            if ($trip_review->status == 1) {
                $trip_review->status = 0;
            } else {
                $trip_review->status = 1;
            }

            if ($trip_review->save()) {
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
}
