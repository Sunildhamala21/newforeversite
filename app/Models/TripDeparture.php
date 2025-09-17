<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripDeparture extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['statusInfo'];

    
    protected function casts(): array  {
        return [
            'from_date' => 'date'
        ];
    }

    public function getToDateAttribute() {
        return $this->from_date->copy()->addDays($this->trip->duration - 1);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function getStatusInfoAttribute()
    {
        if ($this->status == 1) {
            return 'Guarenteed';
        } else {
            return 'Limited';
        }
    }
}
