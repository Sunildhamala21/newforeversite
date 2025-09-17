<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    public function processAndStoreImage(UploadedFile|string $file, Model $model, string $imageName, string $storagePath, ?array $crop_data = null): string
    {
        $quality = 100;
        if ($file instanceof UploadedFile) {
            $quality = $file->getSize() > 1000000 ? 50 : 75;
        }

        $sizes = $model->getImageSizes();

        // dd($sizes);

        $image = Image::read($file);

        if ($crop_data) {
            $image->crop(floor($crop_data['width']), floor($crop_data['height']), floor($crop_data['x']), floor($crop_data['y']));
        }
        Storage::put($storagePath.$imageName, (string) $image->toWebp($quality));

        foreach ($sizes as $size => $dimensions) {
            $current = clone $image;
            $current->cover($dimensions['width'], $dimensions['height']);
            Storage::put($storagePath.$size.'_'.$imageName, (string) $current->toWebp($quality));
        }

        return $imageName;
    }
}
