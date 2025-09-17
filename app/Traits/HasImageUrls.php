<?php

namespace App\Traits;

trait HasImageUrls
{
    protected function generateImageUrl($size = '')
    {
        if (! empty($this->attributes['image_name'] && method_exists($this, 'getBaseImagePath'))) {
            $image_path = $this->getBaseImagePath();
            if ($size) {
                $complete_image_path = $image_path.$size.'_'.$this->attributes['image_name'];
                if (file_exists(public_path($complete_image_path))) {
                    return url($complete_image_path);
                }
            }

            return url($image_path.$this->attributes['image_name']);
        }

        return config('constants.default_image_url');
    }

    public function getImageUrlAttribute()
    {
        return $this->generateImageUrl();
    }

    public function getThumbImageUrlAttribute()
    {
        return $this->generateImageUrl('thumb');
    }

    public function getMediumImageUrlAttribute()
    {
        return $this->generateImageUrl('medium');
    }

    public function getLargeImageUrlAttribute()
    {
        return $this->generateImageUrl('large');
    }
}
