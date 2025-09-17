<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Seo;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RegionController extends Controller
{
    public function index(): View
    {
        $regions = Region::get()->toArray();

        return view('admin.regions.index', compact('regions'));
    }

    public function create(): View
    {
        $destinations = \App\Models\Destination::all();
        $activities = \App\Models\Activity::all();

        return view('admin.regions.add', compact('destinations', 'activities'));
    }

    public function store(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'seo.social_image' => 'nullable|mimes:jpeg,jpg,png,gif,webp|max:10000',
        ]);

        $status = 0;
        $msg = '';
        $region = new Region;
        $region->name = $request->name;
        $region->description = $request->description;
        $region->slug = $this->create_slug_title($region->name);
        $region->status = 1;

        if ($request->hasFile('file')) {
            $region->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($region->save()) {
            // save seo
            if ($request->seo) {
                $this->createSeo($request->seo, $region, $imageService);
            }

            // save destination to the region_destination table
            if ($request->destinations) {
                $region->destinations()->attach($request->destinations);
            }

            // save activities to the region_destination table
            if ($request->activities) {
                $region->activities()->attach($request->activities);
            }

            if ($request->hasFile('file')) {
                $imageService->processAndStoreImage(
                    $request->file,
                    $region,
                    $region->image_name,
                    'public/regions/'.$region->id.'/',
                    json_decode($request->cropped_data, true)
                );
            }

            $status = 1;
            $msg = 'Region created successfully.';
            session()->flash('message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    public function edit($id): View
    {
        $region = Region::with([
            'destinations' => function ($q) {
                $q->pluck('destination_id');
            },
            'seo',
        ])->find($id);

        $destination_ids = $region->destinations->pluck('id')->toArray();
        $destinations = \App\Models\Destination::all();
        $activity_ids = $region->activities->pluck('id')->toArray();
        $activities = \App\Models\Activity::all();

        return view('admin.regions.edit', compact('region', 'destinations', 'destination_ids', 'activities', 'activity_ids'));
    }

    public function update(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'seo.social_image' => 'nullable|mimes:jpeg,jpg,png,gif,webp|max:10000',
        ]);

        $status = 0;
        $msg = '';
        $region = Region::find($request->id);
        $region->name = $request->name;
        $region->description = $request->description;
        $region->slug = $this->create_slug_title($region->name);
        $region->status = 1;

        if ($request->hasFile('file')) {
            $region->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($region->save()) {
            // update seo
            $this->updateSeo($request->seo, $region, $imageService);

            // remove and add new destinations
            if ($request->destinations) {
                $region->destinations()->detach();
                $region->destinations()->attach($request->destinations);
            }

            // remove and add new activities
            if ($request->activities) {
                $region->activities()->detach();
                $region->activities()->attach($request->activities);
            }

            // save image.
            if ($request->hasFile('file')) {
                Storage::deleteDirectory('public/regions/'.$region['id']);
                $imageService->processAndStoreImage(
                    $request->file,
                    $region,
                    $region->image_name,
                    'public/regions/'.$region->id.'/',
                    json_decode($request->cropped_data, true)
                );
            } else {
                if (! empty($request->cropped_data) && Storage::exists('public/regions/'.$region['id'].'/'.$region->image_name)) {
                    $imageService->processAndStoreImage(
                        Storage::get('public/regions/'.$region['id'].'/'.$region->image_name),
                        $region,
                        $region->image_name,
                        'public/regions/'.$region->id.'/',
                        json_decode($request->cropped_data, true)
                    );
                }
            }

            $status = 1;
            $msg = 'Region created successfully.';
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
        $path = 'public/regions/';

        if (Region::find($id)->delete()) {
            Storage::deleteDirectory($path.$id);
            $status = 1;
            $http_status_code = 200;
            $msg = 'Region has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }

    public function regionList()
    {
        $regions = Region::all();

        return response()->json([
            'data' => $regions,
        ]);
    }

    public function createSeo($request, $region, ImageService $imageService)
    {
        $seo = new Seo;
        $seo->meta_title = $request['meta_title'];
        $seo->meta_keywords = $request['meta_keywords'];
        $seo->canonical_url = $request['canonical_url'];
        $seo->meta_description = $request['meta_description'];
        $seo->seoable_id = $region->id;
        $seo->seoable_type = 'region';

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

    public function updateSeo($request, $region, ImageService $imageService)
    {
        if ($region->seo) {
            $seo = $region->seo;
        } else {
            $seo = new Seo;
            $seo->seoable_id = $region->id;
            $seo->seoable_type = 'region';
        }

        $seo->meta_title = $request['meta_title'];
        $seo->meta_keywords = $request['meta_keywords'];
        $seo->canonical_url = $request['canonical_url'];
        $seo->meta_description = $request['meta_description'];

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
