<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamCertificate extends Model
{
    protected $guarded = ['id'];

    public function getfileUrlAttribute()
    {
        if (isset($this->attributes['file']) && ! empty($this->attributes['file'])) {
            $image_url = url('/storage/teams/'.$this->team_id.'/certificates/');

            return $image_url.'/'.$this->attributes['file'];
        }

        return config('constants.default_large_image_url');
    }
}
