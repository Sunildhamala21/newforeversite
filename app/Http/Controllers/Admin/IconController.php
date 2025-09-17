<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class IconController extends Controller
{
    public function __invoke(): View
    {
        $icons = scandir(resource_path('svg'));
        $icons = array_filter($icons, function ($icon) {
            return ! in_array($icon, ['.', '..']) && pathinfo($icon, PATHINFO_EXTENSION) === 'svg';
        });
        $icons = array_map(function ($icon) {
            return str($icon)->chopEnd('.svg')->prepend('icon-');
        }, $icons);

        return view('admin.icons.index', [
            'icons' => $icons,
        ]);
    }
}
