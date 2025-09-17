<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Seo;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(): View
    {
        $activities = Activity::get()->toArray();

        return view('admin.activities.index', compact('activities'));
    }

    public function create(): View
    {
        $destinations = \App\Models\Destination::all();

        return view('admin.activities.add', compact('destinations'));
    }

    public function store(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'file' => 'nullable|image|max:10000',
            'seo.social_image' => 'nullable|image|max:10000',
        ]);

        $status = 0;
        $msg = '';
        $activity = new Activity;
        $activity->name = $request->name;
        $activity->description = $request->description;
        $activity->slug = $this->create_slug_title($activity->name);
        $activity->status = 1;

        if ($request->hasFile('file')) {
            $activity->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($activity->save()) {
            // save seo
            if ($request->seo) {
                $this->createSeo($request->seo, $activity, $imageService);
            }

            // save destination to the activity_destination table
            if ($request->destinations) {
                $activity->destinations()->attach($request->destinations);
            }

            // save image.
            if ($request->hasFile('file')) {
                $imageService->processAndStoreImage(
                    $request->file,
                    $activity,
                    $activity->image_name,
                    'public/activities/'.$activity->id.'/',
                    json_decode($request->cropped_data, true)
                );
            }
            $status = 1;
            $msg = 'Activity created successfully.';
            session()->flash('message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    public function edit($id): View
    {
        $activity = Activity::with([
            'destinations' => function ($q) {
                $q->pluck('destination_id');
            },
            'seo',
        ])->find($id);

        $destination_ids = $activity->destinations->pluck('id')->toArray();
        $destinations = \App\Models\Destination::all();

        return view('admin.activities.edit', compact('activity', 'destinations', 'destination_ids'));
    }

    public function update(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'file' => 'nullable|image|max:10000',
            'seo.social_image' => 'nullable|image|max:10000',
        ]);

        $status = 0;
        $msg = '';
        $activity = Activity::find($request->id);
        $activity->name = $request->name;
        $activity->description = $request->description;
        $activity->slug = $this->create_slug_title($activity->name);
        $activity->status = 1;

        if ($request->hasFile('file')) {
            $activity->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($activity->save()) {

            $this->updateSeo($request->seo, $activity, $imageService);

            if ($request->destinations) {
                $activity->destinations()->detach();
                $activity->destinations()->attach($request->destinations);
            }

            // save image.
            if ($request->hasFile('file')) {
                Storage::deleteDirectory('public/activities/'.$activity['id']);
                $imageService->processAndStoreImage(
                    $request->file,
                    $activity,
                    $activity->image_name,
                    'public/activities/'.$activity->id.'/',
                    json_decode($request->cropped_data, true)
                );
            } else {
                if (! empty($request->cropped_data) && Storage::exists('public/activities/'.$activity['id'].'/'.$activity->image_name)) {
                    $imageService->processAndStoreImage(
                        Storage::get('public/activities/'.$activity['id'].'/'.$activity->image_name),
                        $activity,
                        $activity->image_name,
                        'public/activities/'.$activity->id.'/',
                        json_decode($request->cropped_data, true)
                    );
                }
            }

            $status = 1;
            $msg = 'Activity created successfully.';
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
        $path = 'public/activities/';

        if (Activity::find($id)->delete()) {
            Storage::deleteDirectory($path.$id);
            $status = 1;
            $http_status_code = 200;
            $msg = 'Activity has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }

    public function activityList()
    {
        $activities = Activity::all();

        return response()->json([
            'data' => $activities,
        ]);
    }

    public function createSeo($request, $activity, ImageService $imageService)
    {
        $seo = new Seo;
        $seo->meta_title = $request['meta_title'];
        $seo->meta_keywords = $request['meta_keywords'];
        $seo->canonical_url = $request['canonical_url'];
        $seo->meta_description = $request['meta_description'];
        $seo->seoable_id = $activity->id;
        $seo->seoable_type = 'activity';

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

    public function updateSeo($request, $activity, ImageService $imageService)
    {
        if ($activity->seo) {
            $seo = $activity->seo;
        } else {
            $seo = new Seo;
            $seo->seoable_id = $activity->id;
            $seo->seoable_type = 'activity';
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
