<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UploadService
{
    /**
     * upload the document on the storage
     * @param string $file
     * @param string $uploadPath
     * @return string
     */
    public function upload($file, $uploadPath, $sizes = [])
    {
        $name = $this->getName($file);
        $path = $uploadPath . '/' . $name;
        $pathThumb = $uploadPath . '/thumbnails/' . $name;
        $disk = $this->getDisk();
        $result = Storage::disk($disk)->put($path, file_get_contents($file));

        if (count($sizes)) {
            foreach ($sizes as $size) {
                $height = $size[0];
                $width = $size[1];
                $resized = Image::make(public_path('/uploads/' . $path));
                $resized->resize($width, $height, function ($constraint) {
                    //$constraint->aspectRatio();
                })->save(public_path('/uploads/' . $pathThumb));
            }
        }
        if ($result)
            return $name;
        else
            return false;
    }

    /**
     * get file name
     * @param file $file
     * @return string
     */
    private function getName($file)
    {
        return $file->getClientOriginalName();
    }

    /**
     * get disk
     * @return string
     */
    private function getDisk()
    {
        return  config('custom.upload.disk', 'local');
    }
}
