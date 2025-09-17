<?php

namespace App\Models;

use App\Enums\Difficulty;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Trip extends Model implements Sitemapable
{
    // difficulty_grade = [1 = beginner, 2= easy, 3= moderate, 4= difficult, 5= advance]

    protected $appends = ['imageUrl', 'thumbImageUrl', 'mediumImageUrl', 'largeImageUrl', 'mapImageUrl', 'link', 'galleryLink', 'pdf_link', 'trip_activity_type'];

    public function getPeoplePriceRangeAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getDifficultyAttribute(): ?string
    {
        $difficulty = is_int($this->difficulty_grade) || is_string($this->difficulty_grade)
            ? Difficulty::tryFrom($this->difficulty_grade)
            : null;
        return $difficulty ? $difficulty->name : null;
    }

    public function similar_trips()
    {
        return $this->belongsToMany(Trip::class, 'similar_trips', 'parent_id', 'trip_id');
    }

    public function addon_trips()
    {
        return $this->belongsToMany(Trip::class, 'addon_trips', 'parent_id', 'trip_id');
    }

    public function destinations()
    {
        return $this->belongsToMany(Destination::class);
    }

    public function getDestinationAttribute()
    {
        return $this->destination()->first();
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    public function getRegionAttribute()
    {
        return $this->region()->first();
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }

    public function trip_info()
    {
        return $this->hasOne(TripInfo::class);
    }

    public function trip_include_exclude()
    {
        return $this->hasOne(TripIncludeExclude::class);
    }

    public function trip_seo()
    {
        return $this->hasOne(TripSeo::class);
    }

    public function trip_itineraries()
    {
        return $this->hasMany(TripItinerary::class);
    }

    public function trip_galleries()
    {
        return $this->hasMany(TripGallery::class);
    }

    public function trip_sliders()
    {
        return $this->hasMany(TripSlider::class);
    }

    public function getImageUrlAttribute()
    {
        if (count($this->trip_galleries) > 0) {
            return $this->trip_galleries[0]->imageUrl;
        }

        return asset('assets/front/').config('constants.default_hero_banner');
    }

    public function getMapImageUrlAttribute()
    {
        if (isset($this->attributes['map_file_name']) && ! empty($this->attributes['map_file_name'])) {
            $image_url = url('/storage/trips');

            return $image_url.'/'.$this->attributes['id'].'/'.$this->attributes['map_file_name'];
        }

        return config('constants.default_image_url');
    }

    public function getPdfLinkAttribute()
    {
        if (isset($this->attributes['pdf_file_name']) && ! empty($this->attributes['pdf_file_name'])) {
            $image_url = url('/storage/trips');

            return $image_url.'/'.$this->attributes['id'].'/'.$this->attributes['pdf_file_name'];
        }

        return '';
    }

    public function getThumbImageUrlAttribute()
    {
        if (count($this->trip_galleries) > 0) {
            return $this->trip_galleries[0]->thumbImageUrl;
        }

        return config('constants.default_large_image_url');
    }

    public function getMediumImageUrlAttribute()
    {
        if (count($this->trip_galleries) > 0) {
            return $this->trip_galleries[0]->mediumImageUrl;
        }

        return config('constants.default_large_image_url');
    }

    public function getLargeImageUrlAttribute()
    {
        if (count($this->trip_galleries) > 0) {
            return $this->trip_galleries[0]->largeImageUrl;
        }

        return config('constants.default_large_image_url');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($trip) { // before delete() method call this
            $trip->region()->detach();
            $trip->destination()->detach();
            $trip->activities()->detach();
            $trip->trip_info()->delete();
            $trip->trip_include_exclude()->delete();
            if ($trip->trip_seo()->delete()) {
                $path = 'public/trip-seos/';
                Storage::deleteDirectory($path.$trip->id);
            }
            $trip->trip_itineraries()->delete();
            $path = 'public/trip-galleries/';
            if ($trip->trip_galleries()->delete()) {
                Storage::deleteDirectory($path.$trip->id);
            }
        });
    }

    public function trip_reviews()
    {
        return $this->hasMany('App\Models\TripReview');
    }

    public function trip_faqs()
    {
        return $this->hasMany('App\Models\TripFaq');
    }

    public function getLinkAttribute()
    {
        return route('front.trips.show', $this);
    }

    public function getGalleryLinkAttribute()
    {
        return route('front.trips.galleries', ['slug' => $this->attributes['slug']]);
    }

    public function trip_departures()
    {
        return $this->hasMany('App\Models\TripDeparture');
    }

    public function getTripActivityTypeAttribute()
    {
        if (iterator_count($this->activities)) {
            return $this->activities->first()->name;
        }

        return 'Trekking';
    }

    public function toSitemapTag(): Url|string|array
    {
        return [
            Url::create(route('front.trips.show', $this))
                ->setLastModificationDate(Carbon::create($this->updated_at)),
            Url::create(route('front.trips.print', ['slug' => $this->attributes['slug']]))
                ->setLastModificationDate(Carbon::create($this->updated_at)),
            Url::create(route('front.trips.booking', $this))
                ->setLastModificationDate(Carbon::create($this->updated_at)),
        ];

    }

    public function getBaseImagePath(): string
    {
        return 'storage/trips/'.$this->attributes['id'].'/';
    }

    public function getImageSizes(): array
    {
        return [
            'large' => ['width' => 1600, 'height' => 1000],
            'medium' => ['width' => 360, 'height' => 360],
            'thumb' => ['width' => 100, 'height' => 100],
        ];
    }
}
