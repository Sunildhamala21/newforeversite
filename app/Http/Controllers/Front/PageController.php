<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use TOC\MarkupFixer;
use TOC\TocGenerator;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::where('slug', '=', 'about-us')->first();

        if ($page) {
            return view('front.pages.about', compact('page'));
        }

        return abort(404);
    }

    public function show($slug)
    {
        $page = Page::where('slug', '=', $slug)->firstorFail();

        $body = null;
        $contents = null;
        if ($slug = 'nepal-visa-information') {
            $toc = $page->description;
            $markupFixer = new MarkupFixer;
            $tocGenerator = new TocGenerator;
            $body = $markupFixer->fix($toc);
            $contents = $tocGenerator->getHTMLMenu($body);
        }

        if ($page) {
            return view('front.pages.show', compact('page', 'body', 'contents'));
        }

        return abort(404);
    }
}
