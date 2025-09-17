<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::get()->toArray();

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = \App\Models\Page::all();
        $destinations = \App\Models\Destination::all();
        $trips = \App\Models\Trip::all();
        $activities = \App\Models\Activity::all();
        $regions = \App\Models\Region::all();

        return view('admin.menus.add', compact('pages', 'destinations', 'trips', 'activities', 'regions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::with([
            'menu_items.children' => function ($q) {
                $q->orderBy('display_order', 'asc');
            },
        ])->find($id);
        $menu_items = $menu->menu_items()->where('parent_id', '=', null)->orderBy('display_order', 'asc')->get();

        $pages = \App\Models\Page::all();
        $destinations = \App\Models\Destination::all();
        $trips = \App\Models\Trip::all();
        $activities = \App\Models\Activity::all();
        $regions = \App\Models\Region::all();

        return view('admin.menus.edit', compact('menu', 'pages', 'destinations', 'trips', 'activities', 'regions', 'menu_items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:menus,name',
        ]);

        $status = 0;
        $msg = '';
        $menu = new Menu;
        $menu->name = $request->name;
        $menu->slug = $this->create_slug_title($request->name);

        // $data_items = json_decode($request->menu_items, true);
        // Log::info($data_items);
        if ($menu->save()) {
            if ($request->menu_items) {
                $data_items = json_decode($request->menu_items, true);
                foreach ($data_items as $key => $item) {
                    $this->loopTree($item, $menu->id, $key);
                }
            }
            $status = 1;
            $msg = 'Menu created successfully.';
            session()->flash('message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:menus,name,'.$request->id,
        ]);
        $status = 0;
        $msg = '';
        $menu = Menu::find($request->id);
        $menu->name = $request->name;
        $menu->slug = $this->create_slug_title($request->name);

        // $data_items = json_decode($request->menu_items, true);
        // Log::info($data_items);
        if ($menu->save()) {
            if ($request->menu_items) {
                // delete the existiong sub menus
                if ($menu->menu_items) {
                    $menu->menu_items()->delete();
                }

                $data_items = json_decode($request->menu_items, true);
                foreach ($data_items as $key => $item) {
                    $this->loopTree($item, $menu->id, $key);
                }
            }
            $status = 1;
            $msg = 'Menu updated successfully.';
            session()->flash('message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    // recursive function
    public function loopTree($main_item, $menu_id, $dispay_order = 0, $parent_id = null)
    {
        // save the menu_item and check for its childresn.
        $menu_item = new \App\Models\MenuItem;
        $menu_item->name = $main_item['name'];
        $menu_item->slug = $this->create_slug_title($main_item['name']);
        $menu_item->menu_id = $menu_id;
        $menu_item->display_order = $dispay_order;

        if (isset($main_item['megaMenu'])) {
            $menu_item->mega_menu = $main_item['megaMenu'];
        }

        if ($parent_id) {
            $menu_item->parent_id = $parent_id;
        }

        // if the type is a model.
        if (! in_array($main_item['type'], ['main', 'custom'])) {
            $menu_item->menu_itemable_type = ucfirst($main_item['type']);
            $menu_item->menu_itemable_id = $main_item['id'];
        }

        if ($main_item['type'] == 'custom') {
            $menu_item->link = $main_item['link'];
        }

        if ($menu_item->save()) {
            // if children present call the loop tree again.
            if (isset($main_item['children']) && ! empty($main_item['children'])) {
                foreach ($main_item['children'] as $key => $value) {
                    $this->loopTree($value, $menu_id, $key, $menu_item->id);
                }
            }
        }

        return true;
    }

    public function menuList()
    {
        $menus = Menu::all();

        return response()->json([
            'data' => $menus,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = 0;
        $http_status_code = 400;
        $msg = '';

        if (Menu::find($id)->delete()) {
            $status = 1;
            $http_status_code = 200;
            $msg = 'Menu has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }
}
