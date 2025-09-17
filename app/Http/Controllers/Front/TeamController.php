<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        $administrations = Team::where('type', '=', 1)->get();
        $representatives = Team::where('type', '=', 2)->get();
        $tour_guides = Team::where('type', '=', 3)->get();

        return view('front.teams.index', compact('administrations', 'representatives', 'tour_guides'));
    }

    public function show($slug)
    {
        $team = Team::where('slug', '=', $slug)->firstOrFail();

        return view('front.teams.show', compact('team'));
    }
}
