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
     * @param $image
     * @return string
     */
    public function storeSubPath($image)
    {
        return strtolower($image{0}) . '/' . strtolower($image{1});
    }

    /**
     * @param $image
     * @return string
     */
    public function imagePathToStore($image)
    {
        return '/' . $this->storeSubPath($image) . '/' . $image;
    }

    /**
     * @param $imageData
     * @return string|null
     */
    public function save($imageData)
    {
        if(!File::copy($imageData['source_path'], $imageData['target_path'])) {
            print_r('could not copy file ' . $imageData['source_path'] . ' to path ' . $imageData['target_path']);
            return false;
        }

        dd($this->imagePathToStore($imageData['name']));

        return $this->imagePathToStore($imageData['name']);
    }

}