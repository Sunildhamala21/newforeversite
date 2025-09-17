<?php

namespace App\Providers;

use App\Http\View\Composers\MenuComposer;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Trip;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            // '*', 'App\Http\View\Composers\MenuComposer'
            ['front.elements.header', 'front.elements.footer'], MenuComposer::class
        );

        View::composer('front.trips.show', function ($view) {
            $menu = Menu::where('slug', '=', 'essential-trip-information')->first();
            $essential_trip_informations = [];
            if ($menu) {
                $essential_trip_informations = MenuItem::where('menu_id', '=', $menu->id)->get();
            }

            $monthly_trips = Trip::latest()->limit(5)->get();
            $view->with([
                'essential_trip_informations' => $essential_trip_informations,
                'monthly_trips' => $monthly_trips,
            ]);
        });
    }
}
