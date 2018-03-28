<?php

namespace Laragento\ImportExport\Managers\Import;

interface ImportInterface
{
    const BEHAVIOR_APPEND = 'append';
    const BEHAVIOR_ADD_UPDATE = 'add_update';
    const BEHAVIOR_UPDATE = 'update';
    const BEHAVIOR_REPLACE = 'replace';
    const BEHAVIOR_DELETE = 'delete';
    const BEHAVIOR_CUSTOM = 'custom';
    const IGNORE_STOCK = false;
    const CONFIG_BEHAVIOR = 'behavior';

    const CONFIG_IGNORE_STOCK = 'ignore_stock';
    const CONFIG_ARCHIVE_ON_IMPORT = 'archive';
    const CONFIG_GET_SOURCEFILES_BEFORE_IMPORT = 'get_sourcefiles';
    const CONFIG_STORE_MEDIADATA_ON_IMPORT = 'store_media';

    const CONFIG_IMPORT_BASE_PATH = 'import-base-path';
    const CONFIG_IMPORT_SUB_PATH = 'import-sub-path';
    const CONFIG_IMPORT_ARCHIVE_PATH = 'import-archive-path';
    const CONFIG_STORE_CODE = 'store-code';

    const CONFIG_FILE_HAS_KEYWORD = 'file-has-keyword';

    public function import($config);

    public function setUp();

    public function configure($customerData);

    public function execute();

    public function transform($rawData);

    public function sets();

    public function storagePath($file);

    public function archivePath($path);

    public function executeSet($path);

    public function behavior();

    public function entityCode();

    public function transformer();

    public function repository();

    public function handler();

    public function config($config);

    public function load($path);

    public function archive($path, $move);
}