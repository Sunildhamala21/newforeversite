<?php

namespace App\Models;

use App\Traits\HasImageUrls;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Destination extends Model implements Sitemapable
{
    use HasImageUrls;

    protected $guarded = ['id'];

    protected $appends = ['imageUrl', 'thumbImageUrl', 'mediumImageUrl', 'largeImageUrl', 'link', 'tourGuideImageUrl'];

    public function getBaseImagePath(): string
    {
        return 'storage/destinations/'.$this->attributes['id'].'/';
    }

    public function menu_items()
    {
        return $this->morphMany('App\Models\MenuItem', 'menu_itemable');
    }

    public function getTourGuideImageUrlAttribute()
    {
        if (isset($this->attributes['tour_guide_image_name']) && ! empty($this->attributes['tour_guide_image_name'])) {
            $image_url = url('/storage/destinations');

            return $image_url.'/'.$this->attributes['id'].'/'.$this->attributes['tour_guide_image_name'];
        }

        return asset('assets/front/').config('constants.default_hero_banner');
    }

    public function getLinkAttribute()
    {
        return route('front.destinations.show', $this);
    }

    public function seo()
    {
        return $this->morphOne('App\Models\Seo', 'seoable');
    }

    public function trips()
    {
        return $this->belongsToMany(Trip::class, 'destination_trip', 'destination_id', 'trip_id');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_destination', 'destination_id', 'id');
    }

    public function getImageSizes(): array
    {
        return [
            'large' => ['width' => 1600, 'height' => 1000],
            'medium' => ['width' => 600, 'height' => 450],
            'thumb' => ['width' => 100, 'height' => 100],
        ];
    }

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('front.destinations.show', $this))
            ->setLastModificationDate(Carbon::create($this->updated_at));
        // ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        // ->setPriority(0.8);
    }
}
