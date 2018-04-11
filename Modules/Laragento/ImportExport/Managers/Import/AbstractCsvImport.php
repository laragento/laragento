<?php

namespace Laragento\ImportExport\Managers\Import;

abstract class AbstractCsvImport extends AbstractXmlImport
{
    /**
     * @param $path
     * @return string
     */
    public function load($path)
    {
        try {
            $handle = fopen($path, "r");
            return $handle;
        } catch (Illuminate\Filesystem\FileNotFoundException $exception) {
            die("The file doesn't exist");
        }
    }
}