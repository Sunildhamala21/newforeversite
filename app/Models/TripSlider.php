<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripSlider extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['imageUrl', 'thumbImageUrl', 'mediumImageUrl'];

    public function getImageUrlAttribute()
    {
        if (isset($this->attributes['image_name']) && ! empty($this->attributes['image_name'])) {
            $image_url = url('/storage/trip-sliders');

            return $image_url.'/'.$this->attributes['trip_id'].'/'.$this->attributes['image_name'];
        }

        return config('constants.default_image_url');
    }

    public function getThumbImageUrlAttribute()
    {
        if (isset($this->attributes['image_name']) && ! empty($this->attributes['image_name'])) {
            $image_url = url('/storage/trip-sliders');

            return $image_url.'/'.$this->attributes['trip_id'].'/thumb_'.$this->attributes['image_name'];
        }

        return config('constants.default_image_url');
    }

    public function getMediumImageUrlAttribute()
    {
        if (isset($this->attributes['image_name']) && ! empty($this->attributes['image_name'])) {
            $image_url = url('/storage/trip-sliders');

            return $image_url.'/'.$this->attributes['trip_id'].'/medium_'.$this->attributes['image_name'];
        }

        return config('constants.default_image_url');
    }

    protected function getBaseImagePath()
    {
        return 'storage/trip-sliders/'.$this->attributes['trip_id'].'/';
    }

    public function getImageSizes(): array
    {
        return [
            'large' => ['width' => 880, 'height' => 660],
            'medium' => ['width' => 480, 'height' => 360],
            'thumb' => ['width' => 100, 'height' => 100],
        ];
    }
}
