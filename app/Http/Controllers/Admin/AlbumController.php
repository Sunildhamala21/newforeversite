<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlbumController extends Controller
{
    public function index(): View  {
        return view('admin.albums.index', [
            'albums' => Album::orderBy('sort')->get()
        ]);
    }

    public function store(Request $request) :RedirectResponse  {

        $request->validate([
            'name' => 'string|required|unique:albums',
        ]);
        $request->merge(['slug' => str($request->name)->slug()]);

        Album::create($request->only('name', 'slug'));

        return back()->with('success_message', 'Album added!');
    }

    public function update(Album $album, Request $request) :RedirectResponse  {

        $request->validate([
            'name' => 'string|required|unique:albums,name,'.$album->id,
        ]);
        $request->merge(['slug' => str($request->name)->slug()]);

        $album->update($request->only('name', 'slug'));

        return back()->with('success_message', 'Album added!');
    }

    public function destroy(Album $album): RedirectResponse  {
        $album->delete();
        
        return back()->with('success_message', 'Album deleted!');
    }
}
