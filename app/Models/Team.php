<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    // type = [1 = administration, 2 = representatives, 3 = tour guides]

    protected $guarded = ['id'];

    protected $appends = ['imageUrl', 'thumbImageUrl', 'link'];

    public function getLinkAttribute()
    {
        return route('front.teams.show', ['slug' => $this->attributes['slug']]);
    }

    public function getImageUrlAttribute()
    {
        if (isset($this->attributes['image_name']) && ! empty($this->attributes['image_name'])) {
            $image_url = url('/storage/teams');

            return $image_url.'/'.$this->attributes['id'].'/'.$this->attributes['image_name'];
        }

        return config('constants.default_large_image_url');
    }

    public function getThumbImageUrlAttribute()
    {
        if (isset($this->attributes['image_name']) && ! empty($this->attributes['image_name'])) {
            $image_url = url('/storage/teams');

            return $image_url.'/'.$this->attributes['id'].'/thumb_'.$this->attributes['image_name'];
        }

        return config('constants.default_image_url');
    }

    public function getBaseImagePath(): string
    {
        return 'storage/teams/'.$this->attributes['id'].'/';
    }

    public function getImageSizes(): array
    {
        return [
            'large' => ['width' => 1600, 'height' => 1000],
            'medium' => ['width' => 480, 'height' => 360],
            'thumb' => ['width' => 100, 'height' => 100],
        ];
    }

    public function certificates()
    {
        return $this->hasMany(TeamCertificate::class);
    }

    public function galleries()
    {
        return $this->hasMany(TeamGallery::class);
    }
}
