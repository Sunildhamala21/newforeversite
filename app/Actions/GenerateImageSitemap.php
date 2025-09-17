<?php

namespace App\Actions;

use App\Models\Activity;
use App\Models\Blog;
use App\Models\Destination;
use App\Models\Page;
use App\Models\Region;
use App\Models\Team;
use App\Models\Trip;
use Carbon\Carbon;
use SimpleXMLElement;

class GenerateImageSitemap
{
    public function handle()
    {
        $activities = Activity::where('status', 1)->get();
        $blogs = Blog::where('status', 1)->get();
        $destinations = Destination::where('status', 1)->get();
        $pages = Page::where('status', 1)->get();
        $regions = Region::where('status', 1)->get();
        $trips = Trip::where('status', 1)->get();
        $teams = Team::where('status', 1)->get();

        $newurl = 'http://www.google.com/schemas/sitemap-image/1.1';
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $xml->addAttribute('xmlns:image', $newurl);

        foreach ($trips as $trip) {
            $url = $xml->addChild('url');
            $url->addChild('loc', route('front.trips.show', $trip));
            $url->addChild('lastmod', Carbon::now()->toAtomString());

            $tripImages = array_merge($trip->trip_galleries->toArray() ?? [], $trip->trip_sliders->toArray() ?? []);

            foreach ($tripImages as $gallery) {
                if (! empty($gallery['imageUrl'])) {
                    $image = $url->addChild('image:image', null, $newurl);
                    $image->addChild('image:loc', $gallery['imageUrl']);

                    if (! empty($gallery['caption'])) {
                        $image->addChild('image:title', htmlspecialchars($gallery['caption']));
                    }
                    if (! empty($gallery['alt_tag'])) {
                        $image->addChild('image:caption', htmlspecialchars($gallery['alt_tag']));
                    }
                }
            }
        }

        foreach ($blogs as $blog) {
            $url = $xml->addChild('url');
            $url->addChild('loc', route('front.blogs.show', $blog->slug));
            $url->addChild('lastmod', Carbon::now()->toAtomString());

            if (! empty($blog->imageUrl)) {
                $image = $url->addChild('image:image', null, $newurl);
                $image->addChild('image:loc', $blog->imageUrl);

                if (! empty($blog->name)) {
                    $image->addChild('image:title', htmlspecialchars($blog->name));
                }
                if (! empty($blog->name)) {
                    $image->addChild('image:caption', htmlspecialchars($blog->name));
                }
            }
        }

        foreach ($activities as $activity) {
            $url = $xml->addChild('url');
            $url->addChild('loc', route('front.activities.show', $activity));
            $url->addChild('lastmod', Carbon::now()->toAtomString());

            if (! empty($activity->imageUrl)) {
                $image = $url->addChild('image:image', null, $newurl);
                $image->addChild('image:loc', $activity->imageUrl);

                if (! empty($activity->name)) {
                    $image->addChild('image:title', htmlspecialchars($activity->name));
                }
                if (! empty($activity->name)) {
                    $image->addChild('image:caption', htmlspecialchars($activity->name));
                }
            }
        }

        foreach ($destinations as $destination) {
            $url = $xml->addChild('url');
            $url->addChild('loc', route('front.destinations.show', $destination));
            $url->addChild('lastmod', Carbon::now()->toAtomString());

            if (! empty($destination->imageUrl)) {
                $image = $url->addChild('image:image', null, $newurl);
                $image->addChild('image:loc', $destination->imageUrl);

                if (! empty($destination->name)) {
                    $image->addChild('image:title', htmlspecialchars($destination->name));
                }
                if (! empty($destination->name)) {
                    $image->addChild('image:caption', htmlspecialchars($destination->name));
                }
            }
        }

        foreach ($regions as $region) {
            $url = $xml->addChild('url');
            $url->addChild('loc', route('front.regions.show', $region));
            $url->addChild('lastmod', Carbon::now()->toAtomString());

            if (! empty($region->imageUrl)) {
                $image = $url->addChild('image:image', null, $newurl);
                $image->addChild('image:loc', $region->imageUrl);

                if (! empty($region->name)) {
                    $image->addChild('image:title', htmlspecialchars($region->name));
                }
                if (! empty($region->name)) {
                    $image->addChild('image:caption', htmlspecialchars($region->name));
                }
            }
        }

        foreach ($pages as $page) {
            $url = $xml->addChild('url');
            $url->addChild('loc', route('front.pages.show', $page->slug));
            $url->addChild('lastmod', Carbon::now()->toAtomString());

            if (! empty($page->imageUrl)) {
                $image = $url->addChild('image:image', null, $newurl);
                $image->addChild('image:loc', $page->imageUrl);

                if (! empty($page->name)) {
                    $image->addChild('image:title', htmlspecialchars($page->name));
                }
                if (! empty($page->name)) {
                    $image->addChild('image:caption', htmlspecialchars($page->name));
                }
            }
        }

        foreach ($teams as $team) {
            $url = $xml->addChild('url');
            $url->addChild('loc', route('front.teams.show', $team->slug));
            $url->addChild('lastmod', Carbon::now()->toAtomString());

            if (! empty($team->imageUrl)) {
                $image = $url->addChild('image:image', null, $newurl);
                $image->addChild('image:loc', $team->imageUrl);

                if (! empty($team->name)) {
                    $image->addChild('image:title', htmlspecialchars($team->name));
                }
                if (! empty($team->name)) {
                    $image->addChild('image:caption', htmlspecialchars($team->name));
                }
            }
        }

        $filePath = public_path('sitemap-images.xml');
        $xml->asXML($filePath);
    }
}
