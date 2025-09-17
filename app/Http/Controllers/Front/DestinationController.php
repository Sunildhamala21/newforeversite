<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Trip;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    private $page_limit = 6;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = \App\Models\Destination::query();
            $keyword = $request->keyword;
            if (isset($keyword) && ! empty($keyword)) {
                $query->where('name', 'LIKE', '%'.$keyword.'%');
            }
            $destinations = $query->where('status', '=', 1)->paginate($this->page_limit, ['*'], 'page', $request->page);
            $html = '';
            if (! empty($destinations)) {
                foreach ($destinations as $destination) {
                    $html .= view('front.elements.destination_card')->with(compact('destination'))->render();
                }
            }

            return response()->json([
                'data' => $html,
                'success' => true,
                'pagination' => [
                    'current_page' => $destinations->currentPage(),
                    'next_page' => $destinations->nextPageUrl() ? true : false,
                    'total' => $destinations->total(),
                ],
                'message' => 'List fetched',
            ]);
        } else {
            $block_3_trips = \App\Models\Trip::where('block_3', 1)->latest()->get();
            $destinations = \App\Models\Destination::where('status', '=', 1)->paginate($this->page_limit);
            $activities = \App\Models\Activity::where('status', '=', 1)->get();

            return view('front.destinations.index', compact('destinations', 'activities', 'block_3_trips'));
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $activity_id = $request->act;
        $price_sort = $request->price;
        $query = \App\Models\Destination::query();
        if (isset($keyword) && ! empty($keyword)) {
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        }

        // if (isset($activity_id) && !empty($activity_id)) {
        //     $query->where('activity_id', 'LIKE', '%' . $keyword . '%');
        // }

        // if (isset($price_sort) && !empty($price_sort)) {
        //     # code...
        // }

        $destinations = $query->where('status', '=', 1)->paginate($this->page_limit);
        $html = '';
        if (! empty($destinations)) {
            foreach ($destinations as $destination) {
                $html .= view('front.elements.destination_card')->with(compact('destination'))->render();
            }
        }

        return response()->json([
            'data' => $html,
            'pagination' => [
                'current_page' => $destinations->currentPage(),
                'next_page' => $destinations->nextPageUrl() ? true : false,
                'total' => $destinations->total(),
            ],
            'success' => true,
            'message' => 'List fetched',
        ]);
    }

    public function show(Destination $destination)
    {
        $seo = $destination->seo;
        $destinations = \App\Models\Destination::select('id', 'name')->get();
        $activities = \App\Models\Activity::whereHas('destinations', function ($q) use ($destination) {
            $q->where('destination_id', $destination->id);
        })->take(8)->get();

        return view('front.destinations.show', compact('destination', 'destinations', 'activities', 'seo'));
    }

    public function getTrips(Request $request)
    {
        $ids = $request->ids;

        $keyword = $request->keyword;

        if (isset($keyword) && ! empty($keyword)) {
            $trips = Trip::select('id', 'name', 'slug', 'duration')
                ->where('name', 'LIKE', '%'.$keyword.'%')
                ->whereHas('destinations', function ($q) use ($ids) {
                    $q->whereIn('destination_id', explode(',', $ids));
                })->paginate(20);
        } else {
            $trips = Trip::select('id', 'name', 'slug', 'duration')
                ->whereHas('destinations', function ($q) use ($ids) {
                    $q->whereIn('destination_id', explode(',', $ids));
                })->paginate(20);
        }

        return response()->json([
            'data' => $trips,
            'success' => true,
            'message' => 'List fetched',
        ]);
    }
}
