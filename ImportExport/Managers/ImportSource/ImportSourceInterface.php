<?php


namespace Laragento\ImportExport\Managers\ImportSource;


interface ImportSourceInterface
{
    const MODE = 0755;

    const CONFIG_IMPORTFILES_SOURCEPATH = 'source_path';
    const CONFIG_IMPORTFILES_TARGETPATH = 'target_path';
    const CONFIG_IMPORT_DRIVER = 'driver';
    const CONFIG_IMPORT_FORMATS = 'formats';

    public function import($config);

    public function configure($config);

    public function setSourcePath($path);

    public function getSourcePath();

    public function setTargetPath($path);

    public function getTargetPath();

    public function execute();
}