<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    public function index(): View
    {
        $blogs = BlogCategory::latest()->paginate(9);

        return view('front.blog-categories.index', compact('blogs'));
    }

    public function show(BlogCategory $blogCategory)
    {
        $blogs = $blogCategory->blogs()->orderBy('created_at', 'desc')->paginate(9);

        return view('front.blog-categories.show', [
            'blogs' => $blogs,
            'blogCategory' => $blogCategory,
        ]);
    }
}
