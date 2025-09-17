<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\Component;

class TripadvisorReviewsSection extends Component
{
    public $details;

    public $reviews;

    public function __construct(
    ) {
        $response = (object) Cache::flexible('tripadvisor', [7200, 86400], function () {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])
                ->get(config('services.reviews.endpoint').'/'.config('services.reviews.identifier').'/tripadvisor');

            return $response->json();
        });
        $this->details = (object) $response->details;
        $this->reviews = $response->reviews;
        

        $ratingLevels = [
            5 => 'Excellent',
            4 => 'Very good',
            3 => 'Average',
            2 => 'Poor',
            1 => 'Terrible',
        ];

        // $this->details->rating_definition = $ratingLevels[ceil($this->details->rating)];

        if (isset($this->details->rating) && is_numeric($this->details->rating)) {
            $this->details->rating_definition = $ratingLevels[ceil($this->details->rating)];
        } else {
            $this->details->rating = null;
            $this->details->rating_definition = 'No rating available';
        }
        
    }

    public function render(): View|Closure|string
    {
        return view('components.tripadvisor-reviews-section');
    }
}
