<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Seo;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\Tags\Tag;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('admin.blogs.index');
    }

    public function create(): View
    {
        return view('admin.blogs.add', [
            'blogs' => Blog::orderBy('id', 'asc')->get(),
            'categories' => BlogCategory::all(),
            'tags' => Tag::all(),
        ]);
    }

    public function store(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'file' => 'nullable|image|max:10000',
            'blog_date' => 'nullable|date|date_format:Y-m-d',
            'tags' => 'nullable|array',
        ]);

        $status = 0;
        $msg = '';
        $blog = new Blog;
        $blog->name = $request->name;
        $blog->description = $request->description;
        $blog->blog_date = $request->blog_date;
        $blog->slug = str($blog->name)->slug();
        $blog->toc = $request->toc;
        $blog->status = 1;

        if ($request->hasFile('file')) {
            $blog->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($blog->save()) {
            if ($request->blog_categories) {
                $blog->categories()->attach($request->blog_categories);
            }

            $blog->syncTags($request->tags ?? []);
            // save seo
            if ($request->seo) {
                $this->createSeo($request->seo, $blog, $imageService);
            }
            // save image.
            if ($request->hasFile('file')) {
                $imageService->processAndStoreImage(
                    $request->file,
                    $blog,
                    $blog->image_name,
                    'public/blogs/'.$blog->id.'/',
                    json_decode($request->cropped_data, true)
                );
                $status = 1;
            }

            // save similar trips to the similar_trips table
            if ($request->similar_blogs) {
                $blog->similar_blogs()->attach($request->similar_blogs);
            }

            $status = 1;
            $msg = 'Blog created successfully.';
            session()->flash('message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    public function edit($id): View
    {
        $blog = Blog::with([
            'similar_blogs',
        ])->find($id);

        return view('admin.blogs.edit', [
            'allCategories' => BlogCategory::all(),
            'blog' => $blog,
            'blogs' => Blog::orderBy('name', 'ASC')->where('id', '!=', $id)->get(),
            'category_ids' => $blog->categories->pluck('id')->toArray(),
            'similar_blog_ids' => $blog->similar_blogs->pluck('id')->toArray(),
            'tags' => Tag::all(),
        ]);
    }

    public function update(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'file' => 'nullable|image|max:10000',
            'blog_date' => 'nullable|date|date_format:Y-m-d',
        ]);

        $status = 0;
        $msg = '';
        $blog = Blog::find($request->id);
        $blog->name = $request->name;
        $blog->description = $request->description;
        $blog->blog_date = $request->blog_date;
        $blog->slug = $this->create_slug_title($blog->name);
        $blog->toc = $request->toc;
        $blog->status = 1;

        if ($request->hasFile('file')) {
            $blog->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($blog->save()) {
            $blog->categories()->detach();
            $blog->categories()->attach($request->blog_categories);
            $blog->syncTags($request->tags ?? []);
            $this->updateSeo($request->seo, $blog, $imageService);

            if ($request->hasFile('file')) {
                Storage::deleteDirectory('public/blogs/'.$blog['id']);
                $imageService->processAndStoreImage(
                    $request->file,
                    $blog,
                    $blog->image_name,
                    'public/blogs/'.$blog->id.'/',
                    json_decode($request->cropped_data, true)
                );
            }

            if ($request->similar_blogs) {
                $blog->similar_blogs()->detach();
                $blog->similar_blogs()->attach($request->similar_blogs);
            }

            $status = 1;
            $msg = 'Blog updated successfully.';
            session()->flash('message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    public function destroy($id)
    {
        $status = 0;
        $http_status_code = 400;
        $msg = '';
        $path = 'public/blogs/';

        if (Blog::find($id)->delete()) {
            Storage::deleteDirectory($path.$id);
            $status = 1;
            $http_status_code = 200;
            $msg = 'Blog has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }

    public function blogList()
    {
        $blogs = Blog::latest()->get();

        return response()->json([
            'data' => $blogs,
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
        $seo->seoable_type = 'blog';

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

    public function updateSeo($request, $blog, ImageService $imageService)
    {
        if ($blog->seo) {
            $seo = $blog->seo;
        } else {
            $seo = new Seo;
            $seo->seoable_id = $blog->id;
            $seo->seoable_type = 'blog';
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
