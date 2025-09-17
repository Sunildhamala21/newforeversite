<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['fileUrl'];

    public function getFileUrlAttribute()
    {
        if (isset($this->attributes['file']) && ! empty($this->attributes['file'])) {
            $image_url = url('/storage/documents');

            return $image_url.'/'.$this->attributes['id'].'/'.$this->attributes['file'];
        }

        return config('constants.default_image_url');
    }

    protected function getBaseImagePath()
    {
        return 'storage/documents/'.$this->attributes['id'].'/';
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
