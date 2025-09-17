<?php

namespace App\View\Components;

use App\Models\Activity;
use App\Models\Destination;
use App\Models\Region;
use App\Models\Trip;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class FilterTrips extends Component
{
    public function __construct(
        private Request $request,
        private ?Destination $destination,
        private ?Activity $activity,
        private ?Region $region)
    {}

    public function render(): View|Closure|string
    {
        $keyword = $this->request->string('keyword');

        if ($this->activity && $this->activity->exists){
            $activitySlugs = [$this->activity->slug];
        } else {
            $activitySlugs = $this->request->activities ? explode(',',  $this->request->activities) : [];
        }

        if ($this->destination && $this->destination->exists){
            $destinationSlugs = [$this->destination->slug];
        } else {
            $destinationSlugs = $this->request->destinations ? explode(',',  $this->request->destinations) : [];
        }

        if ($this->region && $this->region->exists){
            $regionSlugs = [$this->region->slug];
        } else {
            $regionSlugs = [];
        }

        $difficultySlugs = $this->request->difficulties ? explode(',', $this->request->difficulties) : [];
        $difficulties = array_map(fn($item) => \App\Enums\Difficulty::{str($item)->title()->toString()}->value, $difficultySlugs);
        $duration = $this->request->duration ? explode('-', $this->request->duration) : [];
        $price = $this->request->price ? explode('-', $this->request->price) : [];

        $query = Trip::select('id', 'name', 'slug', 'duration', 'difficulty_grade', 'cost', 'offer_price');

        if ($keyword) {
            $query->whereLike('name', '%' . $keyword . '%');
        }

        if (!empty($activitySlugs)) {
            $query->whereHas('activities', function ($q) use ($activitySlugs) {
                $q->whereIn('activities.slug', $activitySlugs);
            });
        }

        if (!empty($destinationSlugs)) {
            $query->whereHas('destinations', function ($q) use ($destinationSlugs) {
                $q->whereIn('destinations.slug', $destinationSlugs);
            });
        }

        if (!empty($regionSlugs)) {
            $query->whereHas('regions', function ($q) use ($regionSlugs) {
                $q->whereIn('regions.slug', $regionSlugs);
            });
        }

        if (!empty($difficulties)) {
            $query->whereIn('difficulty_grade', $difficulties);
        }

        if (!empty($duration) && count($duration) === 2) {
            if (!$duration[0]) {
                $query->where('duration', '<=', (int) $duration[1]);
            } elseif (!$duration[1]) {
                $query->where('duration', '>=', (int) $duration[0]);
            } else {
                $query->whereBetween('duration', [(int) $duration[0], (int) $duration[1]]);
            }
        }

        if (!empty($price) && count($price) === 2) {
            if (!$price[0]) {
                $query->where('cost', '<=', (int) $price[1]);
            } elseif (!$price[1]) {
                $query->where('cost', '>=', (int) $price[0]);
            } else {
                $query->whereBetween('cost', [(int) $price[0], (int) $price[1]]);
            }
        }
        $data['trips'] = $query->get();

        $data['destinations'] = Destination::where('status', '=', 1)->get();
        $data['activities'] = Activity::where('status', '=', 1)->get();

        $allTrips = Trip::select('duration')->get();
        $data['minDurationAllTrips'] = $allTrips->min('duration');
        $data['maxDurationAllTrips'] = $allTrips->max('duration');

        $data['filters'] = [
            'keyword' => $keyword,
            'activities' => $activitySlugs,
            'destinations' => $destinationSlugs,
            'regions' => $regionSlugs,
            'difficulties' => $difficultySlugs,
            'minDuration' => array_key_exists(0, $duration) ? $duration[0] : null,
            'maxDuration' => array_key_exists(1, $duration) ? $duration[1] : null,
            'minPrice' => array_key_exists(0, $price) ? $price[0] : null,
            'maxPrice' => array_key_exists(1, $price) ? $price[1] : null,
        ];

        return view('components.filter-trips', $data);
    }
}
