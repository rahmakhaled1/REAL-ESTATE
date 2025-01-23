<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function uploadImage($image, $path = 'uploads'){
        return $image->store($path, 'uploads');
    }

    public static function deleteImage($image){
        if ($image && Storage::disk("uploads")->exists($image)) {
            return Storage::disk("uploads")->delete($image);
        }
    }

    public static function updateImage($newImages, $oldImages, $path = 'uploads')
    {
        foreach ($oldImages as $image) {
            self::deleteImage($image->image);
            $image->delete();
        }
        $uploadedImages = [];
        foreach ($newImages as $image) {
            $uploadedImages[] = self::uploadImage($image, $path);
        }

        return $uploadedImages;
    }

}
