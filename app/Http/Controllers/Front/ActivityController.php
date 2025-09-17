<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    private $page_limit = 8;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Activity::query();
            $keyword = $request->keyword;
            if (isset($keyword) && ! empty($keyword)) {
                $query->where('name', 'LIKE', '%'.$keyword.'%');
            }
            $activities = $query->where('status', '=', 1)->paginate($this->page_limit, ['*'], 'page', $request->page);
            $html = '';
            if (! empty($activities)) {
                foreach ($activities as $activity) {
                    $html .= view('front.elements.activity-card')->with(compact('activity'))->render();
                }
            }

            return response()->json([
                'data' => $html,
                'success' => true,
                'pagination' => [
                    'current_page' => $activities->currentPage(),
                    'next_page' => $activities->nextPageUrl() ? true : false,
                    'total' => $activities->total(),
                ],
                'message' => 'List fetched',
            ]);
        } else {
            $block_3_trips = \App\Models\Trip::where('block_3', 1)->latest()->get();
            $activities = \App\Models\Activity::where('status', '=', 1)->paginate($this->page_limit);

            return view('front.activities.index', compact('activities', 'block_3_trips'));
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $activity_id = $request->act;
        $price_sort = $request->price;
        $query = Activity::query();
        if (isset($keyword) && ! empty($keyword)) {
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        }

        $activities = $query->where('status', '=', 1)->paginate($this->page_limit);
        $html = '';
        if (! empty($activities)) {
            foreach ($activities as $activity) {
                $html .= view('front.elements.activity-card')->with(compact('activity'))->render();
            }
        }

        return response()->json([
            'data' => $html,
            'pagination' => [
                'current_page' => $activities->currentPage(),
                'next_page' => $activities->nextPageUrl() ? true : false,
                'total' => $activities->total(),
            ],
            'success' => true,
            'message' => 'List fetched',
        ]);
    }

    public function show(Activity $activity)
    {
        $seo = $activity->seo;
        $destinations = \App\Models\Destination::select('id', 'name')->get();
        $activities = \App\Models\Activity::select('id', 'name')->get();
        $sub_activities = $activity->children;
        $regions = \App\Models\Region::whereHas('activities', function ($query) {
            $query->where('activity_id', 1);
        })->get();
        $find_climbing_expedition_regions = \App\Models\Region::whereHas('activities', function ($query) use ($activity) {
            $query->where('activity_id', $activity->id);
        })->get();

        return view('front.activities.show', compact('activity', 'destinations', 'activities', 'seo', 'regions', 'sub_activities', 'find_climbing_expedition_regions'));
    }
}
