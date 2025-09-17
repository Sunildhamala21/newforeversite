<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if (config('app.env') === 'production') {
        //     URL::forceScheme('https');
        // }
        Model::unguard();
        Schema::defaultStringLength(191);
        Relation::morphMap([
            'Page' => \App\Models\Page::class,
            'Destination' => \App\Models\Destination::class,
            'Activity' => \App\Models\Activity::class,
            'Trip' => \App\Models\Trip::class,
            'Region' => \App\Models\Region::class,
            'Blog' => \App\Models\Blog::class,
        ]);
    }
}
