<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogCategory extends Model implements HasMedia, Sitemapable
{
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('large')
            ->fit(Fit::Crop, 1600, 1000)
            ->format('webp')
            ->nonQueued();
        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 200, 200)
            ->format('webp')
            ->nonQueued();
    }

    public function toSitemapTag(): Url|string|array
    {
        return [
            Url::create(route('front.blog-categories.show', $this))
                ->setLastModificationDate(Carbon::create($this->updated_at)),
        ];
    }
}
