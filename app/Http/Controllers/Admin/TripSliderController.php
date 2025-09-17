<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TripSlider;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TripSliderController extends Controller
{
    public function storeTripGallery(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'gallery' => 'required|mimes:jpeg,jpg,png,gif,webp|max:10000',
        ]);

        $status = 0;
        $msg = '';
        $gallery = new TripSlider;
        $gallery->status = 1;
        $gallery->trip_id = $request->trip_id;
        $gallery->alt_tag = $request->alt_tag;

        if ($request->hasFile('gallery')) {
            $gallery->image_name = md5($request->gallery->getClientOriginalName().microtime()).'.webp';
        }

        if ($gallery->save()) {
            $imageService->processAndStoreImage(
                $request->gallery,
                $gallery,
                $gallery->image_name,
                'public/trip-sliders/'.$gallery->trip_id.'/',
                json_decode($request->cropped_data, true)
            );

            $status = 1;
            $msg = 'Gallery saved successfully.';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    public function deleteTripImage($id)
    {
        $status = 0;
        $http_status_code = 400;
        $msg = '';
        $path = 'public/trip-sliders/';

        $gallery = TripSlider::find($id);

        $trip_id = $gallery->trip_id;
        $image_name = $gallery->image_name;

        if ($gallery->delete()) {
            Storage::delete($path.$trip_id.'/'.$image_name);
            $status = 1;
            $http_status_code = 200;
            $msg = 'Gallery has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }

    public function editSlider($id)
    {
        $slider = TripSlider::find($id);

        return view('admin.trips.edit-gallery', compact('slider'));
    }

    public function updateTripSlider(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'gallery' => 'required|mimes:jpeg,jpg,png,gif,webp|max:10000',
        ]);

        $status = 0;
        $msg = '';
        $slider = TripSlider::find($request->id);
        $slider->alt_tag = $request->alt_tag;
        $slider->status = 1;

        if ($request->hasFile('gallery')) {
            $slider->image_name = md5($request->gallery->getClientOriginalName().microtime()).'.webp';
        }

        if ($slider->save()) {
            if ($request->hasFile('gallery')) {
                Storage::delete('public/trip-sliders/'.$slider->trip_id.'/'.$slider->image_name);
                Storage::delete('public/trip-sliders/'.$slider->trip_id.'/large_'.$slider->image_name);
                Storage::delete('public/trip-sliders/'.$slider->trip_id.'/medium_'.$slider->image_name);
                Storage::delete('public/trip-sliders/'.$slider->trip_id.'/thumb_'.$slider->image_name);
                $imageService->processAndStoreImage(
                    $request->gallery,
                    $slider,
                    $slider->image_name,
                    'public/trip-sliders/'.$slider->trip_id.'/',
                    json_decode($request->cropped_data, true)
                );
            } else {
                if (! empty($request->cropped_data)) {
                    $imageService->processAndStoreImage(
                        Storage::get('public/trip-sliders/'.$slider->trip_id.'/'),
                        $slider,
                        $slider->image_name,
                        'public/trip-sliders/'.$slider->trip_id.'/',
                        json_decode($request->cropped_data, true)
                    );
                }
            }

            $status = 1;
            $msg = 'Gallery updated successfully.';
            session()->flash('message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }
}
