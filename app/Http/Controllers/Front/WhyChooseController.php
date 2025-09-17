<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\WhyChoose;

class WhyChooseController extends Controller
{
    public function index()
    {
        $chooses = WhyChoose::latest()->get();

        return view('front.whyChooses.index', compact('chooses'));
    }

    public function show($id)
    {
        $choose = WhyChoose::find($id);

        return view('front.whyChooses.show', compact('choose'));
    }
}
