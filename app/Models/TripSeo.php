<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripSeo extends Model
{
    protected $appends = ['ogImageUrl'];

    protected $guarded = ['id'];

    public function getOgImageUrlAttribute()
    {
        if (isset($this->attributes['og_image']) && ! empty($this->attributes['og_image'])) {
            $image_url = url('/storage/trip-seos');

            return $image_url.'/'.$this->attributes['id'].'/'.$this->attributes['og_image'];
        }

        return null;
    }
}
