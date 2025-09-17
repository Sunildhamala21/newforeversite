<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChoose extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['imageUrl', 'thumbImageUrl'];

    public function getImageUrlAttribute()
    {
        if (isset($this->attributes['image_name']) && ! empty($this->attributes['image_name'])) {
            $image_url = url('/storage/why-chooses');

            return $image_url.'/'.$this->attributes['id'].'/'.$this->attributes['image_name'];
        }

        return config('constants.default_image_url');
    }

    public function getThumbImageUrlAttribute()
    {
        if (isset($this->attributes['image_name']) && ! empty($this->attributes['image_name'])) {
            $image_url = url('/storage/why-chooses');

            return $image_url.'/'.$this->attributes['id'].'/thumb_'.$this->attributes['image_name'];
        }

        return config('constants.default_image_url');
    }

    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    public function getLinkAttribute()
    {
        return route('front.why-chooses.show', ['id' => $this->id]);
    }

    protected function getBaseImagePath()
    {
        return 'storage/why-chooses/'.$this->attributes['id'].'/';
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
