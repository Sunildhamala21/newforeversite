<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripReview extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['imageUrl', 'thumbImageUrl'];

    public function trip()
    {
        return $this->belongsTo('App\Models\Trip');
    }

    public function getImageUrlAttribute()
    {
        if (isset($this->attributes['image_name']) && ! empty($this->attributes['image_name'])) {
            $image_url = url('/storage/trip-reviews');

            return $image_url.'/'.$this->attributes['id'].'/'.$this->attributes['image_name'];
        }

    }

    public function getThumbImageUrlAttribute()
    {
        if (isset($this->attributes['image_name']) && ! empty($this->attributes['image_name'])) {
            $image_url = url('/storage/trip-reviews');

            return $image_url.'/'.$this->attributes['id'].'/thumb_'.$this->attributes['image_name'];
        }

    }

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    public function getBaseImagePath(): string
    {
        return 'storage/trip-reviews/'.$this->attributes['id'].'/';
    }

    public function getImageSizes(): array
    {
        return [
            'large' => ['width' => 1600, 'height' => 1000],
            'medium' => ['width' => 480, 'height' => 360],
            'thumb' => ['width' => 100, 'height' => 100],
        ];
    }
}
