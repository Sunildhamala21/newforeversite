<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class DescriptionImageController extends Controller
{
    public function saveDescImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|max:10000',
        ]);
        if ($request->hasFile('upload')) {
            $imageName = $request->file('upload')->getClientOriginalName();
            $imageType = $request->file('upload')->getClientOriginalExtension();
            $imageName = md5($imageName.microtime()).'.'.$imageType;
            $path = 'public/description-images/';
            $image = Image::read($request->file('upload'));
            Storage::put($path.$imageName, (string) $image->toJpeg(90));
        }
        $image_url = url('/storage/description-images');

        return response()->json([
            'url' => $image_url.'/'.$imageName,
        ]);
    }

    public function deleteDescImage(Request $request)
    {
        $image_name = array_slice(explode('/', $request->src), -1)[0];
        Storage::delete('/public/description-images/'.$image_name);

        return response()->json([
            'status' => 1,
            'message' => 'image deleted.',
        ]);
    }
}
