<?php

namespace App\Models;

use App\Traits\HasImageUrls;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasImageUrls;

    protected $guarded = ['id'];

    protected $appends = ['imageUrl', 'thumbImageUrl', 'mediumImageUrl', 'largeImageUrl'];

    public function getBaseImagePath(): string
    {
        return 'storage/banners/'.$this->attributes['id'].'/';
    }

    public function getImageSizes(): array
    {
        return [
            'large' => ['width' => 1600, 'height' => 1000],
            'medium' => ['width' => 1200, 'height' => 800],
            'thumb' => ['width' => 100, 'height' => 100],
        ];
    }
}
