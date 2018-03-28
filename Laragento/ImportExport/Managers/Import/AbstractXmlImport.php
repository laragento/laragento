<?php

namespace Laragento\ImportExport\Managers\Import;

use Illuminate\Support\Facades\File;

abstract class AbstractXmlImport extends AbstractImport
{
    /**
     * @param $path
     * @param $move
     */
    public function archive($path, $move)
    {
        try {
            if ($move && $this->config[ImportInterface::CONFIG_ARCHIVE_ON_IMPORT]) {
                File::move($path, $move);
            }
        } catch (Illuminate\Filesystem\FileNotFoundException $exception) {
            die("The file doesn't exist");
        }
    }

    /**
     * @param $path
     * @return mixed
     */
    public function load($path)
    {
        try {
            $setData = simplexml_load_string(File::get($path));
            return $setData;
        } catch (Illuminate\Filesystem\FileNotFoundException $exception) {
            die("The file doesn't exist");
        } catch (\Exception $exception) {
            die($exception->getMessage() . ' - ' . $exception->getCode());
        }
    }
}