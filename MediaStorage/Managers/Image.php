<?php

namespace Laragento\MediaStorage\Managers;

use Illuminate\Support\Facades\File;
use League\Flysystem\FileNotFoundException;


class Image implements ImageInterface
{
    /**
     * @param $path
     * @return mixed
     */
    public function archivePath($path): string
    {
        dd('archive path is not yet implemented');
    }

    /**
     * @param $imageData
     * @return string|null
     */
    public function save($imageData)
    {
        $dir = dirname($imageData['target_path']);
        if(!File::exists($dir)) {
            File::makeDirectory($dir, 0775, true);
        }

        if(!File::copy($imageData['source_path'], $imageData['target_path'])) {
            print_r('could not copy file ' . $imageData['source_path'] . ' to path ' . $imageData['target_path']);
            return false;
        }

        return true;
    }

}