<?php

namespace App\Models;

use App\Traits\HasImageUrls;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Page extends Model implements Sitemapable
{
    use HasImageUrls;

    protected $guarded = ['id'];

    protected $appends = ['imageUrl', 'thumbImageUrl', 'link'];

    public function getBaseImagePath(): string
    {
        return 'storage/pages/'.$this->attributes['id'].'/';
    }

    public function menu_items()
    {
        return $this->morphMany('App\MenuItem', 'menu_itemable');
    }

    public function menu_item()
    {
        return $this->morphOne('App\MenuItem', 'menu_itemable');
    }

    public function getLinkAttribute()
    {
        return route('front.pages.show', ['slug' => $this->attributes['slug']]);
    }

    public function seo()
    {
        return $this->morphOne('App\Models\Seo', 'seoable');
    }

    public function getImageSizes(): array
    {
        return [
            'large' => ['width' => 1600, 'height' => 1000],
            'medium' => ['width' => 480, 'height' => 360],
            'thumb' => ['width' => 100, 'height' => 100],
        ];
    }

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('front.pages.show', ['slug' => $this->attributes['slug']]))
            ->setLastModificationDate(Carbon::create($this->attributes('updated_at')));
    }
}
