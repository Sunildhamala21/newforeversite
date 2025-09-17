<?php

namespace App\Models;

use App\Traits\HasImageUrls;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Spatie\Tags\HasTags;

class Blog extends Model implements Sitemapable
{
    use HasImageUrls;
    use HasTags;

    protected $guarded = ['id'];

    protected $appends = ['imageUrl', 'thumbImageUrl', 'mediumImageUrl', 'largeImageUrl', 'link'];

    public function getBaseImagePath(): string
    {
        return 'storage/blogs/'.$this->attributes['id'].'/';
    }

    public function getLinkAttribute()
    {
        return route('front.blogs.show', ['slug' => $this->attributes['slug']]);
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
        return Url::create(route('front.blogs.show', ['slug' => $this->attributes['slug']]))
            ->setLastModificationDate(Carbon::create($this->updated_at));
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(BlogCategory::class);
    }

    public function similar_blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'similar_blogs', 'parent_id', 'blog_id');
    }
}
