<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Region;

class RegionController extends Controller
{
    public function show(Region $region)
    {
        $seo = $region->seo;
        $destinations = \App\Models\Destination::select('id', 'name')->get();
        $activities = \App\Models\Activity::select('id', 'name')->get();

        return view('front.regions.show', compact('region', 'destinations', 'activities', 'seo'));
    }
}
