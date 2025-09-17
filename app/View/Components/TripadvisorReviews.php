<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TripadvisorReviews extends Component
{
    public function __construct(public array $reviews) {}

    public function render()
    {
        return view('components.tripadvisor-reviews');
    }
}
