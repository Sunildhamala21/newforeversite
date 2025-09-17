<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $appends = ['socialImageUrl'];

    /**
     * Get the owning seoable model.
     */
    public function seoable()
    {
        return $this->morphTo();
    }

    public function getSocialImageUrlAttribute()
    {
        if (isset($this->attributes['social_image']) && ! empty($this->attributes['social_image'])) {
            $image_url = url('/storage/seos');

            return $image_url.'/'.$this->attributes['id'].'/'.$this->attributes['social_image'];
        }

        return '';
    }

    public function getBaseImagePath(): string
    {
        return 'storage/seos/'.$this->attributes['id'].'/';
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
