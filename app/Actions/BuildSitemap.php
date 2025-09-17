<?php

namespace App\Actions;

use App\Models\Activity;
use App\Models\Blog;
use App\Models\Destination;
use App\Models\Region;
use App\Models\Trip;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class BuildSitemap
{
    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Trip::where('status', 1)->get())
            ->add(Url::create(route('front.trips.index'))
                ->setLastModificationDate(Carbon::today())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(1))
            ->add(Blog::where('status', 1)->get())
            ->add(Url::create(route('front.blogs.index'))
                ->setLastModificationDate(Carbon::today())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.9))
            ->add(Destination::where('status', 1)->get())
            ->add(Url::create(route('front.destinations.index'))
                ->setLastModificationDate(Carbon::today())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8))
            ->add(Activity::where('status', 1)->get())
            ->add(Url::create(route('front.activities.index'))
                ->setLastModificationDate(Carbon::today())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8))
            ->add(Region::where('status', 1)->get());
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
