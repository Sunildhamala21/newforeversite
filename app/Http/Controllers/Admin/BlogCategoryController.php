<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index()
    {
        return view('admin.blog-categories.index');
    }

    public function create()
    {
        return view('admin.blog-categories.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'nullable|image',
            'seo' => 'nullable|array',
            'seo.meta_title' => 'nullable|string',
            'seo.meta_description' => 'nullable|string',
            'seo.meta_keywords' => 'nullable|string',
            'seo.canonical_url' => 'nullable|string',
        ]);

        $request->merge(['slug' => str($request->name)->slug()]);

        $blogCategory = BlogCategory::create($request->only('name', 'slug', 'description'));

        if ($request->hasFile('file')) {
            $blogCategory->addMediaFromRequest('file')->toMediaCollection();
        }

        $blogCategory->seo()->create([
            'meta_title' => $request->seo['meta_title'],
            'meta_description' => $request->seo['meta_description'],
            'meta_keywords' => $request->seo['meta_keywords'],
            'canonical_url' => $request->seo['canonical_url'],
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Added Blog Category',
        ]);
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog-categories.edit', [
            'category' => $blogCategory,
        ]);
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'nullable|image',
            'seo' => 'nullable|array',
            'seo.meta_title' => 'nullable|string',
            'seo.meta_description' => 'nullable|string',
            'seo.meta_keywords' => 'nullable|string',
            'seo.canonical_url' => 'nullable|string',
        ]);

        $request->merge(['slug' => str($request->name)->slug()]);

        $blogCategory->update($request->only('name', 'slug', 'description'));

        if ($request->hasFile('file')) {
            $blogCategory->addMediaFromRequest('file')->toMediaCollection();
        }

        $blogCategory->seo()->update([
            'meta_title' => $request->seo['meta_title'],
            'meta_description' => $request->seo['meta_description'],
            'meta_keywords' => $request->seo['meta_keywords'],
            'canonical_url' => $request->seo['canonical_url'],
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Updated Blog Category',
        ]);
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Blog Category deleted',
        ]);
    }

    public function list()
    {
        $blogs = BlogCategory::all()->map(function ($category) {
            $category->image = $category->getFirstMediaUrl('default', 'thumb');

            return $category;
        });

        return response()->json([
            'data' => $blogs,
        ]);
    }
}
