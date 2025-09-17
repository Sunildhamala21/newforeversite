<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        $banners = Banner::get()->toArray();

        return view('admin.banners.index', compact('banners'));
    }

    public function create(): View
    {
        return view('admin.banners.add');
    }

    public function store(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:10000',
        ]);
        $status = 0;
        $msg = '';

        $banner = new Banner;
        $banner->caption = $request->caption;
        $banner->image_alt = $request->image_alt;
        $banner->btn_link = $request->btn_link;

        if ($request->hasFile('file')) {
            $banner->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($banner->save()) {
            $imageService->processAndStoreImage(
                $request->file,
                $banner,
                $banner->image_name,
                'public/banners/'.$banner->id.'/',
            );
        }

        $status = 1;
        $msg = 'Banner added successfully.';
        session()->flash('message', $msg);

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    public function bannerList()
    {
        $banners = Banner::all();

        return response()->json([
            'data' => $banners,
        ]);
    }

    public function edit($id)
    {
        $banner = Banner::find($id);

        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, ImageService $imageService)
    {
        $status = 0;
        $msg = '';
        $banner = Banner::find($request->id);
        $banner->image_alt = $request->image_alt;
        $banner->caption = $request->caption;
        $banner->btn_link = $request->btn_link;
        $banner->status = 1;

        if ($request->hasFile('file')) {
            $banner->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($banner->save()) {
            if ($request->hasFile('file')) {
                Storage::deleteDirectory('public/banners/'.$banner['id']);
                $imageService->processAndStoreImage(
                    $request->file,
                    $banner,
                    $banner->image_name,
                    'public/banners/'.$banner->id.'/',
                );
            }

            $status = 1;
            $msg = 'Banner updated successfully.';
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
        $path = 'public/banners/';

        if (Banner::find($id)->delete()) {
            Storage::deleteDirectory($path.$id);
            $status = 1;
            $http_status_code = 200;
            $msg = 'Banner has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }
}
