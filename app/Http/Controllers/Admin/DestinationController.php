<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Seo;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class DestinationController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::get()->toArray();

        return view('admin.destinations.index', compact('destinations'));
    }

    public function create(): View
    {
        return view('admin.destinations.add');
    }

    public function store(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'seo.social_image' => 'nullable|mimes:jpeg,jpg,png,gif,webp|max:10000',
        ]);

        $status = 0;
        $msg = '';

        $destination = new Destination;
        $destination->name = $request->name;
        $destination->description = $request->description;
        $destination->tour_guide_description = $request->tour_guide_description;
        $destination->slug = $this->create_slug_title($destination->name);
        $destination->status = 1;

        if ($request->hasFile('tour_guide_image_name')) {
            $tour_guide_image_name = $request->tour_guide_image_name->getClientOriginalName();
            $destination->map_original_file_name = $tour_guide_image_name;
            $tourFileSize = $request->tour_guide_image_name->getSize();
            $mapImageType = $request->tour_guide_image_name->getClientOriginalExtension();
            $tour_guide_image_nameUniqid = md5($tour_guide_image_name.microtime()).'.'.$mapImageType;
            $tour_guide_image_name = $tour_guide_image_nameUniqid;
            $destination->tour_guide_image_name = $tour_guide_image_nameUniqid;
        }

        if ($request->hasFile('file')) {
            $destination->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($destination->save()) {
            if ($request->hasFile('file')) {
                $imageService->processAndStoreImage(
                    $request->file,
                    $destination,
                    $destination->image_name,
                    'public/destinations/'.$destination->id.'/',
                    json_decode($request->cropped_data, true)
                );
            }

            if ($request->seo) {
                $this->createSeo($request->seo, $destination, $imageService);
            }

            if ($request->hasFile('tour_guide_image_name')) {

                $image_quality = 100;

                if (($tourFileSize / 1000000) > 1) {
                    $image_quality = 75;
                }

                $path = 'public/destinations/';

                $image = Image::read($request->tour_guide_image_name);

                Storage::put($path.$destination['id'].'/'.$tour_guide_image_name, (string) $image->toJpeg($image_quality));

                $file = $path.$destination['id'].'/'.$tour_guide_image_name;
                if (! Storage::exists($file)) {
                    $destination->tour_guide_image_name = '';
                    $destination->save();
                }
            }
        }

        $status = 1;
        $msg = 'Destination created successfully.';
        session()->flash('message', $msg);

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    public function edit($id)
    {
        $destination = Destination::with('seo')->find($id);

        return view('admin.destinations.edit', compact('destination'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImageService $imageService)
    {
        $request->validate([
            'name' => 'required',
            'seo.social_image' => 'nullable|mimes:jpeg,jpg,png,gif,webp|max:10000',
        ]);

        $status = 0;
        $msg = '';
        $destination = Destination::find($request->id);
        $destination->name = $request->name;
        $destination->description = $request->description;
        $destination->tour_guide_description = $request->tour_guide_description;
        $destination->slug = $this->create_slug_title($destination->name);
        $destination->status = 1;

        if ($request->hasFile('tour_guide_image_name')) {
            $old_tour_guide_file_name = $destination->tour_guide_image_name;
            $tourImageSize = $request->tour_guide_image_name->getSize();
            $tourimageType = $request->tour_guide_image_name->getClientOriginalExtension();
            $tourimageNameUniqid = md5(microtime()).'.'.$tourimageType;
            $tour_guide_image_name = $tourimageNameUniqid;

            $destination->tour_guide_image_name = $tour_guide_image_name;
        }

        if ($request->hasFile('file')) {
            $destination->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($destination->save()) {
            // update seo
            $this->updateSeo($request->seo, $destination, $imageService);

            if ($request->hasFile('tour_guide_image_name')) {

                $image_quality = 100;

                if (($tourImageSize / 1000000) > 1) {
                    $image_quality = 75;
                }

                $path = 'public/destinations/';

                $image = Image::read($request->tour_guide_image_name);

                // store new image
                Storage::put($path.$destination['id'].'/'.$tour_guide_image_name, (string) $image->toJpeg($image_quality));

                // delete old image
                if (isset($old_tour_guide_file_name) && ! empty($old_tour_guide_file_name)) {
                    Storage::delete($path.$destination['id'].'/'.$old_tour_guide_file_name);
                    $file = $path.$destination['id'].'/'.$tour_guide_image_name;
                    if (! Storage::exists($file)) {
                        $destination->tour_guide_image_name = '';
                        $destination->save();
                    }
                }
            } else {

                if ($request->has_tour_guide_image == 0) {
                    $path = 'public/destinations/';
                    Storage::delete($path.$destination['id'].'/'.$destination['tour_guide_image_name']);
                    $destination->tour_guide_image_name = '';
                    $destination->save();
                }
            }

            // save image.
            if ($request->hasFile('file')) {
                Storage::deleteDirectory('public/destinations/'.$destination['id']);
                $imageService->processAndStoreImage(
                    $request->file,
                    $destination,
                    $destination->image_name,
                    'public/destinations/'.$destination->id.'/',
                    json_decode($request->cropped_data, true)
                );
            }

            $status = 1;
            $msg = 'Destination created successfully.';
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
        $path = 'public/destinations/';

        if (Destination::find($id)->delete()) {
            Storage::deleteDirectory($path.$id);
            $status = 1;
            $http_status_code = 200;
            $msg = 'Destination has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }

    public function destinationList()
    {
        $destinations = Destination::all();

        return response()->json([
            'data' => $destinations,
        ]);
    }

    public function createSeo($request, $destination, ImageService $imageService)
    {
        $seo = new Seo;
        $seo->meta_title = $request['meta_title'];
        $seo->meta_keywords = $request['meta_keywords'];
        $seo->canonical_url = $request['canonical_url'];
        $seo->meta_description = $request['meta_description'];
        $seo->seoable_id = $destination->id;
        $seo->seoable_type = 'destination';

        if ($seo->save()) {
            if (isset($request['social_image']) && ! empty($request['social_image'])) {
                $social_image = $request['social_image'];
                $socialImageName = $social_image->getClientOriginalName();
                $socialImageFileSize = $social_image->getSize();
                $socialImageType = $social_image->getClientOriginalExtension();
                // $socialImageNameUniqid = md5(microtime()) . '.' . $socialImageType;
                $socialImageNameUniqid = md5(microtime()).'.jpeg';
                $socialImageName = $socialImageNameUniqid;
                $seo->social_image = $socialImageName;
                $croppedData = isset($request['cropped_data']) ? json_decode($request['cropped_data'], true) : null;

                $imageService->processAndStoreImage(
                    $social_image = $request['social_image'],
                    $seo,
                    $seo->social_image = $socialImageName,
                    'public/seos/'.$seo->id.'/',
                    $croppedData
                );

                $seo->save();
            }

            return 1;
        }

        return 0;
    }

    public function updateSeo($request, $destination, ImageService $imageService)
    {
        if ($destination->seo) {
            $seo = $destination->seo;
        } else {
            $seo = new Seo;
            $seo->seoable_id = $destination->id;
            $seo->seoable_type = 'destination';
        }

        $seo->meta_title = $request['meta_title'];
        $seo->meta_keywords = $request['meta_keywords'];
        $seo->canonical_url = $request['canonical_url'];
        $seo->meta_description = $request['meta_description'];

        if ($seo->save()) {

            if (isset($request['social_image']) && ! empty($request['social_image'])) {
                $social_image = $request['social_image'];
                $socialImageName = $social_image->getClientOriginalName();
                $socialImageNameUniqid = md5(microtime()).'.jpeg';
                $socialImageName = $socialImageNameUniqid;
                $seo->social_image = $socialImageName;
                $croppedData = isset($request['cropped_data']) ? json_decode($request['cropped_data'], true) : null;
                Storage::deleteDirectory('public/seos/'.$seo['id']);
                $imageService->processAndStoreImage(
                    $social_image = $request['social_image'],
                    $seo,
                    $seo->social_image = $socialImageName,
                    'public/seos/'.$seo->id.'/',
                    $croppedData
                );

                $seo->save();
            }

            return 1;
        }

        return 0;
    }
}
