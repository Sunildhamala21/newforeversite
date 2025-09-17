<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyChoose;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WhyChooseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chooses = WhyChoose::get()->toArray();

        return view('admin.whyChooses.index', compact('chooses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.whyChooses.add');
    }

    public function whyChooseList()
    {
        $chooses = WhyChoose::all();

        return response()->json([
            'data' => $chooses,
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
            'title' => 'required',
            'description' => 'required',
            'file' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:20000',
        ]);

        $status = 0;
        $msg = '';
        $why_choose = new WhyChoose;
        $why_choose->title = $request->title;
        $why_choose->description = $request->description;

        if ($request->hasFile('file')) {
            $why_choose->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($why_choose->save()) {
            // save image.
            if ($request->hasFile('file')) {
                $imageService->processAndStoreImage(
                    $request->file,
                    $why_choose,
                    $why_choose->image_name,
                    'public/why-chooses/'.$why_choose->id.'/',
                    json_decode($request->cropped_data, true)
                );
                $status = 1;
            }
            $status = 1;
            $msg = 'Why Choose Us created successfully.';
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
        $why_choose = WhyChoose::find($id);

        $trips = \App\Models\Trip::all();

        return view('admin.whyChooses.edit', compact('why_choose', 'trips'));
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
            'title' => 'required',
            'description' => 'required',
            'file' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:20000',
        ]);

        $status = 0;
        $msg = '';
        $why_choose = WhyChoose::find($request->id);
        $why_choose->title = $request->title;
        $why_choose->description = $request->description;

        if ($request->hasFile('file')) {
            $why_choose->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($why_choose->save()) {
            // save image.
            if ($request->hasFile('file')) {
                Storage::deleteDirectory('public/why-chooses/'.$why_choose['id']);
                $imageService->processAndStoreImage(
                    $request->file,
                    $why_choose,
                    $why_choose->image_name,
                    'public/why-chooses/'.$why_choose->id.'/',
                    json_decode($request->cropped_data, true)
                );
            } else {
                if (! empty($request->cropped_data)) {
                    $imageService->processAndStoreImage(
                        Storage::get('public/why-chooses/'.$why_choose['id'].'/'.$why_choose->image_name),
                        $why_choose,
                        $why_choose->image_name,
                        'public/why-chooses/'.$why_choose->id.'/',
                        json_decode($request->cropped_data, true)
                    );
                }
            }

            $status = 1;
            $msg = 'Updated successfully.';
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
        $path = 'public/why-chooses/';

        if (WhyChoose::find($id)->delete()) {
            Storage::deleteDirectory($path.$id);
            $status = 1;
            $http_status_code = 200;
            $msg = 'The option has been deleted';
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

        $why_choose = WhyChoose::find($id);

        if ($why_choose) {
            if ($why_choose->status == 1) {
                $why_choose->status = 0;
            } else {
                $why_choose->status = 1;
            }

            if ($why_choose->save()) {
                $message = 'The option has been published.';
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
