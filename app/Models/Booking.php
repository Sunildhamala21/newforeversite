<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    protected $guarded = [];

    protected function casts()
    {
        return [
            'trips.pivot.start_date' => 'date',
            'trips.pivot.end_date' => 'date',
        ];
    }

    public function trips(): BelongsToMany
    {
        return $this->belongsToMany(Trip::class)->withPivot(['no_of_travelers', 'start_date', 'end_date', 'price'])->withTimestamps();
    }
}
