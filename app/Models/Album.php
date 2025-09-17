<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Album extends Model implements HasMedia, Sortable
{
    use InteractsWithMedia;
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
        ->fit(Fit::Crop, 240, 240)
        ->format('webp')
        ->nonQueued();
        
        $this->addMediaConversion('large')
        ->fit(Fit::Contain, 2400, 2400)
        ->format('webp')
        ->nonQueued();
    }
}
