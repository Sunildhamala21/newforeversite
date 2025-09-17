<?php

namespace App\Models;

use App\Traits\HasImageUrls;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Region extends Model implements Sitemapable
{
    use HasImageUrls;

    protected $guarded = [];

    protected $guard = ['id'];

    protected $fillable = [
        'name',
        'description',
    ];

    protected $appends = ['imageUrl', 'thumbImageUrl', 'mediumImageUrl', 'largeImageUrl', 'link'];

    public function destinations()
    {
        return $this->belongsToMany(Destination::class)->withTimestamps();
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class)->withTimestamps();
    }

    public function getLinkAttribute()
    {
        return route('front.regions.show', $this);
    }

    public function seo()
    {
        return $this->morphOne('App\Models\Seo', 'seoable');
    }

    public function trips()
    {
        return $this->belongsToMany(Trip::class, 'region_trip', 'region_id', 'trip_id');
    }

    public function getBaseImagePath(): string
    {
        return 'storage/regions/'.$this->attributes['id'].'/';
    }

    public function getImageSizes(): array
    {
        return [
            'large' => ['width' => 1600, 'height' => 1000],
            'medium' => ['width' => 360, 'height' => 360],
            'thumb' => ['width' => 100, 'height' => 100],
        ];
    }

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('front.regions.show', $this))
            ->setLastModificationDate(Carbon::create($this->attributes['updated_at']));
        // ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        // ->setPriority(0.7);
    }
}
