<?php

namespace App\Http\View\Composers;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\WhyChoose;
use Illuminate\View\View;

class MenuComposer
{
    protected $menus;

    protected $footer1;

    protected $footer2;

    protected $footer3;

    protected $footer_why_choose_us;

    public function __construct()
    {
        $primary = Menu::first();
        if ($primary) {
            $this->menus = MenuItem::where('menu_id', '=', $primary->id)->with([
                'children' => function ($q) {
                    $q->orderBy('display_order', 'asc');
                },
            ])->where('parent_id', '=', null)->orderBy('display_order', 'asc')->get();
        }

        $footer1 = Menu::where('name', '=', 'footer1')->first();
        if ($footer1) {
            $this->footer1 = MenuItem::where('menu_id', '=', $footer1->id)->with('children')->where('parent_id', '=', null)->get();
        }

        $footer2 = Menu::where('name', '=', 'footer2')->first();
        if ($footer2) {
            $this->footer2 = MenuItem::where('menu_id', '=', $footer2->id)->with('children')->where('parent_id', '=', null)->get();
        }

        $footer3 = Menu::where('name', '=', 'footer3')->first();
        if ($footer3) {
            $this->footer3 = MenuItem::where('menu_id', '=', $footer3->id)->with('children')->where('parent_id', '=', null)->get();
        }

        $this->footer_why_choose_us = WhyChoose::where('status', 1)->get();
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'menus' => $this->menus,
            'footer1' => $this->footer1,
            'footer2' => $this->footer2,
            'footer3' => $this->footer3,
            'footer_why_choose_us' => $this->footer_why_choose_us,
        ]);
    }
}
