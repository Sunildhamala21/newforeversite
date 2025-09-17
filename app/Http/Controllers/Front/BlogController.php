<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Team;
use App\Models\Trip;
use Illuminate\Support\Str;
use TOC\MarkupFixer;
use TOC\TocGenerator;

class BlogController extends Controller
{
    public function index()
    {
        return view('front.blogs.index', [
            'blogs' => Blog::latest()->paginate(12),
            'categories' => BlogCategory::all(),
        ]);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', '=', $slug)->with('similar_blogs')->firstOrFail();
        if ($blog) {
            $author = Team::first();
            $description = $blog->toc;

            // render views for shortcodes
            preg_match_all('/\[(.*?)\]/', $description, $matches);
            $shortcodes = $matches[0] ?? [];
            foreach ($shortcodes as $shortcode) {
                $extracted = Str::of($shortcode)->between('[', ']');
                if (! Str::contains($extracted, ':')) {
                    continue;
                }
                [$type, $slug] = explode(':', $extracted, 2);
                if ($type == 'trip') {
                    $trip = Trip::whereSlug($slug)->withCount('trip_reviews')->withAvg('trip_reviews', 'rating')->first();
                    if ($trip) {
                        $renderedView = view('components.editor.trip', ['trip' => $trip])->render();
                        $description = str_replace($shortcode, $renderedView, $description);
                    }
                }
            }

            if ($description != '') {
                $markupFixer = new MarkupFixer;
                $tocGenerator = new TocGenerator;
                $body = $markupFixer->fix($description);
                $contents = $tocGenerator->getHTMLMenu($body);
            } else {
                $body = '';
                $contents = '';
            }

            $blogs = Blog::limit(3)->latest()->get();

            return view('front.blogs.show', compact('blog', 'author', 'blogs', 'contents', 'body'));
        }
    }

    public function listTagged($tag)
    {
        return view('front.blogs.index', [
            'blogs' => Blog::withAnyTags($tag)->with('tags')->paginate(12),
            'tag' => $tag,
        ]);
    }
}
