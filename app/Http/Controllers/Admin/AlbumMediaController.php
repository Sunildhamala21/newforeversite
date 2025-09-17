<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AlbumMediaController extends Controller
{
    public function index(Album $album): View   {
        return view('admin.albums.media.index', [
            'album' => $album
        ]);
    }

    public function store(Album $album, Request $request): RedirectResponse  {
        $request->validate([
            'photo' => 'required|image',
            'caption' => 'nullable|string',
        ]);

        $album
        ->addMediaFromRequest('photo')
                ->withCustomProperties([
                'caption'=> $request->caption
        ])
        ->toMediaCollection();

        return back()->with('success_message', 'Photo added!');
    }

    public function update(Album $album, Media $medium, Request $request): RedirectResponse  {
        $request->validate([
            'photo' => 'nullable|image',
            'caption' => 'nullable|string',
        ]);

        if($request->hasFile('photo')) {
            $album
                ->addMediaFromRequest('photo')
                ->withCustomProperties([
                    'caption'=> $request->caption
                ])
                ->toMediaCollection();
            $medium->delete();
        } else {
            $medium->setCustomProperty('caption', $request->string('caption'));
            $medium->save();
        }

        return back()->with('success_message', 'Photo added!');
    }

    public function destroy(Album $album, Media $medium): JsonResponse  {
        $medium->delete();

        return response()-> json(['success'=>1, 'message' => 'Photo deleted!']);
    }
}
