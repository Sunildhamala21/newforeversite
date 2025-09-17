<?php

namespace App\Http\Controllers;

use App\Actions\BuildSitemap;
use Illuminate\Support\Facades\File;

class SitemapController extends Controller
{
    public function generate(BuildSitemap $buildSitemap)
    {
        $buildSitemap->handle();
        session()->flash('message', 'Sitemap generated successfully');

        return to_route('admin.dashboard');
    }

    public function index()
    {
        // Path to the sitemap file
        $path = public_path('sitemap.xml');

        // Check if the file exists
        if (File::exists($path)) {
            // Read the content of the file
            $content = File::get($path);

            // Return the sitemap content as a response
            return response($content)
                ->header('Content-Type', 'application/xml');
        } else {
            // If the file does not exist, return a 404 response
            abort(404);
        }
    }
}
