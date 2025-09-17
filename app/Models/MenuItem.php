<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['type'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function menu_itemable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->hasOne(MenuItem::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id', 'id')->with('children');
    }

    public function getLinkAttribute($value)
    {
        if (! $value) {
            if (isset($this['menu_itemable']) && ! empty($this['menu_itemable'])) {
                return $this['menu_itemable']['link'];
            }

            return '';
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        } else {
            // check for slug
            $page = \App\Models\Page::where('slug', '=', $value)->first();
            if ($page) {
                return $page->link;
            } else {
                return url('/').'/'.$value;
            }
        }

        return $value;
    }

    public function getTypeAttribute()
    {
        if ($this->menu_itemable_type) {
            $type = $this->menu_itemable_type;
        } else {
            if ($this->link) {
                $type = 'custom';
            } else {
                $type = 'main';
            }
        }

        return $type;
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
