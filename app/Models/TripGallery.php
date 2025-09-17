<?php

namespace App\Models;

use App\Traits\HasImageUrls;
use Illuminate\Database\Eloquent\Model;

class TripGallery extends Model
{
    use HasImageUrls;

    protected $guarded = ['id'];

    protected $appends = ['imageUrl', 'thumbImageUrl', 'mediumImageUrl', 'largeImageUrl'];

    protected function getBaseImagePath()
    {
        return 'storage/trip-galleries/'.$this->attributes['trip_id'].'/';
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
