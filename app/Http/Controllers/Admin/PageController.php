<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Seo;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::get()->toArray();

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.add');
    }

    public function store(Request $request, ImageService $imageService)
    {
        $request->validate([
            'name' => 'required',
            'seo.social_image' => 'nullable|mimes:jpeg,jpg,png,gif,webp|max:10000',
        ]);

        $status = 0;
        $msg = '';
        $page = new Page;
        $page->name = $request->name;
        $page->description = $request->description;
        $page->slug = $this->create_slug_title($page->name);
        $page->status = 1;

        if ($request->hasFile('file')) {
            $page->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($page->save()) {
            // save seo
            if ($request->seo) {
                $this->createSeo($request->seo, $page, $imageService);
            }

            // save image.
            if ($request->hasFile('file')) {
                $imageService->processAndStoreImage(
                    $request->file,
                    $page,
                    $page->image_name,
                    'public/pages/'.$page->id.'/',
                    json_decode($request->cropped_data, true)
                );
                $status = 1;
            }
            $status = 1;
            $msg = 'Page created successfully.';
            session()->flash('message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    public function edit($id): View
    {
        $page = Page::with('seo')->find($id);

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'seo.social_image' => 'nullable|mimes:jpeg,jpg,png,gif,webp|max:10000',
        ]);

        $status = 0;
        $msg = '';
        $page = Page::find($request->id);
        $page->name = $request->name;
        $page->description = $request->description;
        $page->slug = $this->create_slug_title($page->name);
        $page->status = 1;

        if ($request->hasFile('file')) {
            $page->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($page->save()) {
            // update seo
            $this->updateSeo($request->seo, $page, $imageService);

            // save image.
            if ($request->hasFile('file')) {
                Storage::deleteDirectory('public/pages/'.$page['id']);
                $imageService->processAndStoreImage(
                    $request->file,
                    $page,
                    $page->image_name,
                    'public/pages/'.$page->id.'/',
                    json_decode($request->cropped_data, true)
                );
            } else {
                if (! empty($request->cropped_data)) {
                    $imageService->processAndStoreImage(
                        Storage::get('public/pages/'.$page['id'].'/'.$page->image_name),
                        $page,
                        $page->image_name,
                        'public/pages/'.$page->id.'/',
                        json_decode($request->cropped_data, true)
                    );
                }
            }

            $status = 1;
            $msg = 'Page updated successfully.';
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
        $path = 'public/pages/';

        if (Page::find($id)->delete()) {
            Storage::deleteDirectory($path.$id);
            $status = 1;
            $http_status_code = 200;
            $msg = 'Page has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }

    public function pageList()
    {
        $pages = Page::all();

        return response()->json([
            'data' => $pages,
        ]);
    }

    public function createSeo($request, $page, ImageService $imageService)
    {
        $seo = new Seo;
        $seo->meta_title = $request['meta_title'];
        $seo->meta_keywords = $request['meta_keywords'];
        $seo->canonical_url = $request['canonical_url'];
        $seo->meta_description = $request['meta_description'];
        $seo->seoable_id = $page->id;
        $seo->seoable_type = 'page';

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

    public function updateSeo($request, $page, ImageService $imageService)
    {
        if ($page->seo) {
            $seo = $page->seo;
        } else {
            $seo = new Seo;
            $seo->seoable_id = $page->id;
            $seo->seoable_type = 'page';
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
            } else {
                if (! empty($request->cropped_data)) {
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
                        Storage::get('public/seos/'.$seo['id'].'/'.$seo->image_name),
                        $social_image = $request['social_image'],
                        $seo,
                        $seo->social_image = $socialImageName,
                        'public/seos/'.$seo->id.'/',
                        $croppedData
                    );
                }
            }

            return 1;
        }

        return 0;
    }
}
