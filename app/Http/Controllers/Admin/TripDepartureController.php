<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TripDeparture;
use Illuminate\Http\Request;

class TripDepartureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trips = \App\Models\Trip::whereHas('trip_departures')->get()->toArray();

        return view('admin.tripDepartures.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trips = \App\Models\Trip::all();

        return view('admin.tripDepartures.add', compact('trips'));
    }

    public function departureList()
    {
        $trips = \App\Models\Trip::whereHas('trip_departures')->get();

        return response()->json([
            'data' => $trips,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required',
            'trip_departures.*' => 'required',
        ]);

        $status = 0;
        $msg = '';
        $saved = false;

        foreach ($request->trip_departures as $item) {
            $trip_departure = new TripDeparture;
            $trip_departure->trip_id = $request->trip_id;
            $trip_departure->from_date = $item['from_date'];
            $trip_departure->to_date = $item['to_date'];
            $trip_departure->seats = $item['seats'];
            $trip_departure->price = $item['price'];
            $trip_departure->status = $item['status'];
            if ($trip_departure->save()) {
                $saved = true;
            } else {
                break;
            }
        }

        if ($saved) {
            $status = 1;
            $msg = 'Trip departure created successfully.';
            session()->flash('success_message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trip_departures = TripDeparture::where('trip_id', '=', $id)->get();

        $trip_id = $id;
        $trip = \App\Models\Trip::find($id);
        $trips = \App\Models\Trip::all();

        return view('admin.tripDepartures.edit', compact('trip_departures', 'trips', 'trip_id', 'trip'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'trip_id' => 'required',
            'trip_departures.*' => 'required',
        ]);

        $saved = false;
        $status = 0;
        $msg = '';

        $trip = \App\Models\Trip::find($request->trip_id);

        if ($trip->trip_departures()->delete()) {
            foreach ($request->trip_departures as $item) {
                $trip_departure = new TripDeparture;
                $trip_departure->trip_id = $request->trip_id;
                $trip_departure->from_date = $item['from_date'];
                $trip_departure->to_date = $item['to_date'];
                $trip_departure->seats = $item['seats'];
                $trip_departure->price = $item['price'];
                $trip_departure->status = $item['status'];
                if ($trip_departure->save()) {
                    $saved = true;
                } else {
                    break;
                }
            }
        }

        if ($saved) {
            $status = 1;
            $msg = 'Trip departure updated successfully.';
            session()->flash('success_message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = 0;
        $http_status_code = 400;
        $msg = '';

        if (TripDeparture::find($id)->delete()) {
            $status = 1;
            $http_status_code = 200;
            $msg = 'Trip departure has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }
}
