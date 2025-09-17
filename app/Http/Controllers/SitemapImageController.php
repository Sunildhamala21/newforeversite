<?php

namespace App\Http\Controllers;

use App\Actions\GenerateImageSitemap;
use Illuminate\Support\Facades\File;

class SitemapImageController extends Controller
{
    public function index()
    {
        $path = public_path('sitemap-images.xml');

        if (File::exists($path)) {

            $content = File::get($path);

            return response($content)
                ->header('Content-Type', 'application/xml');
        } else {
            abort(404);
        }
    }

    public function generate(GenerateImageSitemap $buildSitemapImage)
    {
        $buildSitemapImage->handle();
        session()->flash('message', 'Image Sitemap generated successfully');

        return to_route('admin.dashboard');
    }
}
