<?php

namespace Laragento\MediaStorage\Managers;

use Illuminate\Support\Facades\File;


class Image implements ImageInterface
{
    const MODE = 0755;

    protected $sourcePath;
    protected $targetPath;
    protected $baseDirectory;

    public function __construct()
    {
        $this->baseDirectory = '';
    }

    /**
     * @param $sourcePath
     */
    public function setSourcePath($sourcePath)
    {
        $this->sourcePath = $sourcePath;
    }

    public function getSourcePath()
    {
        return $this->sourcePath;
    }

    /**
     * @param $targetPath
     */
    public function setTargetPath($targetPath)
    {
        $this->targetPath = $targetPath;
    }

    public function getTargetPath()
    {
        return $this->targetPath;
    }

    /**
     * @return string
     */
    public function getBaseDirectory()
    {
        return $this->baseDirectory;
    }

    /**
     * @param string $baseDirectory
     */
    public function setBaseDirectory(string $baseDirectory)
    {
        $this->baseDirectory = $baseDirectory;
    }

    /**
     * @param $image
     * @return string
     */
    public function sourcePath($image): string
    {
        $baseSourcePath = storage_path() . '/' . $this->sourcePath;

        return realpath($baseSourcePath) . '/' . $image;

    }

    /**
     * @param $image
     * @return string
     */
    public function targetPath($image): string
    {
        $baseTargetPath = base_path() . '/' . $this->targetPath . '/' . $this->baseDirectory . $this->storeSubPath($image);
        if (!File::exists($baseTargetPath)) {
            File::makeDirectory($baseTargetPath, self::MODE, true);
        }
        return realpath($baseTargetPath) . '/' . $image;

    }

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
    public function directory($image)
    {
        return public_path($this->getBaseDirectory() . $this->storeSubPath($image));
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
        //set paths
        $this->setSourcePath($imageData['source_path']);
        $this->setTargetPath($imageData['target_path']);

        dd($this->sourcePath($imageData));

        if ($image) {

            try {
                File::copy($this->sourcePath($image), $this->targetPath($image));
                $image = $this->imagePathToStore($image);;
            } catch (Illuminate\Filesystem\FileNotFoundException $exception) {
                print_r("source file $image not found " . $exception->getMessage());
                $image = null;
            } catch (\ErrorException $exception) {
                //print_r("source file $image doesn't exist " . $exception->getMessage());

                $image = null;
            }

//                  print_r([
//                        'image'=>$image,
//                        'path'=>$path,
//                        'copy'=>$copy,
//                        'directory'=>$directory,
//                        'imageNameToStore'=>$imageNameToStore,
//                  ]);
        }
        return $image;
    }

}