<?php

namespace Laragento\ImportExport\Managers\Import;

use Illuminate\Support\Facades\Storage;
use Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepository;
use Laragento\Catalog\Repositories\Category\CategoryProductRepository;
use Laragento\Catalog\Repositories\Inventory\InventoryRepository;
use Laragento\Catalog\Repositories\Media\ImageRepository;
use Laragento\Catalog\Repositories\Product\ProductAttributeRepository;
use Laragento\Catalog\Repositories\Product\ProductLinkRepository;
use Laragento\Catalog\Repositories\Product\ProductRepository;
use Laragento\CatalogImportExport\Repositories\ProductImportRepository;
use Laragento\CatalogImportExport\Repositories\ProductImportRepositoryInterface;
use Laragento\Eav\Repositories\AttributeRepository;
use Laragento\ImportExport\Managers\ImportSource\ImportSourceInterface;
use Laragento\Store\Repositories\StoreRepository;
use Spatie\Fractal\Fractal;

abstract class AbstractImport implements ImportInterface
{
    protected $messages;
    protected $behavior;

    //ToDo: Perhaps "subset" is a better solution (similar to the importsource-files)
    protected $entityCode;

    protected $transformer;
    protected $repository;
    protected $handler;
    protected $config = [
        ImportInterface::CONFIG_IMPORT_BASE_PATH => '',
        ImportInterface::CONFIG_IMPORT_SUB_PATH => '',
        ImportInterface::CONFIG_IMPORT_ARCHIVE_PATH => '',
        ImportInterface::CONFIG_BEHAVIOR => ImportInterface::BEHAVIOR_ADD_UPDATE,
        ImportInterface::CONFIG_IGNORE_STOCK => ImportInterface::IGNORE_STOCK,
        ImportInterface::CONFIG_FILE_HAS_KEYWORD => false,
        ImportInterface::CONFIG_ARCHIVE_ON_IMPORT => false,
        ImportInterface::CONFIG_GET_SOURCEFILES_BEFORE_IMPORT => true,
        ImportInterface::CONFIG_STORE_MEDIADATA_ON_IMPORT => true,
        ImportInterface::CONFIG_STORE_CODE => false,
    ];

    /**
     * @param $config
     * @return mixed
     */
    public function import($config = false)
    {
        $this->setUp();
        $this->configure($config);
        $this->execute();
        return $this->messages;
    }

    /**
     *
     */
    public function setUp()
    {

    }

    /**
     * @param $config
     */
    public function configure($config)
    {
        $this->config($config);
        $this->behavior = $this->behavior();
        $this->entityCode = $this->entityCode();
        $this->transformer = $this->transformer();
        $this->repository = $this->repository();
    }

    /**
     *
     */
    public function execute()
    {
        if ($this->config[ImportInterface::CONFIG_GET_SOURCEFILES_BEFORE_IMPORT] === true) {
            $importSourceRepo = new XMLImportSource();
            $importSourceRepo->import(false);
        }

        foreach ($this->sets() as $set) {
            if ($this->config[ImportInterface::CONFIG_FILE_HAS_KEYWORD]) {
                if (!str_contains($set, $this->config[ImportInterface::CONFIG_FILE_HAS_KEYWORD])) {
                    continue;
                }
            }

            $path = $this->storagePath($set);
            $this->executeSet($path);

            //ToDo Why do we break here??
            //break;
        }
    }

    /**
     * @param $rawData
     * @return array
     */
    public function transform($rawData): array
    {
        return Fractal::create($rawData, $this->transformer)->toArray();
    }

    /**
     * @return array
     */
    public function sets(): array
    {
        $path = $this->config[ImportInterface::CONFIG_IMPORT_BASE_PATH]
            . $this->entityCode
            . $this->config[ImportInterface::CONFIG_IMPORT_SUB_PATH];
        $sets = Storage::files($path);
        if (empty($sets)) {
            print_r(' SETS-PATH:  ' . $path . '   ');
            print_r(' Not import sets found.   ');
        }

        return $sets;
    }

    /**
     * @param $file
     * @return string
     */
    public function storagePath($file): string
    {
        $path = storage_path('app/' . $file);
        return $path;
    }

    /**
     * @param $path
     * @return mixed
     */
    public function archivePath($path): string
    {
        $move = str_replace('/' . $this->entityCode . '/', '/' . $this->entityCode . '/'.$this->config[ImportInterface::CONFIG_IMPORT_ARCHIVE_PATH].'/', $path);
        return $move;
    }

    /**
     * @param $path
     */
    public function executeSet($path)
    {
        $setData = $this->load($path);
        $data = $this->transform($setData);

        //ToDo Seems redundant as the import function also calls the configure function
        //$this->repository->configure($this->config);

        $this->repository->import($data, $this->config);
        if ($this>$this->config([ImportInterface::CONFIG_ARCHIVE_ON_IMPORT] == true)) {
            $move = $this->archivePath($path);
            $this->archive($path, $move);
        }

    }

    /**
     * @param $newConfig
     * @todo replace with array function
     */
    public function config($newConfig)
    {
        if ($newConfig) {
            foreach ($this->config as $configKey => $configEntry) {
                if (isset($newConfig[$configKey])) {
                    $this->config[$configKey] = $newConfig[$configKey];
                }
            }
        }
    }

    public function handler()
    {
        // TODO: Implement handler() method.
    }


    /**
     * @return ProductImportRepositoryInterface
     */
    public function repository()
    {
        return new ProductImportRepository(
            new ProductRepository(
                new StoreRepository(),
                new ImageRepository(),
                new ProductAttributeRepository(
                    new AttributeRepository(),
                    new CatalogAttributeRepository()
                ),
                new CategoryProductRepository()
            ),
            new ProductLinkRepository(),
            new InventoryRepository()
        );
    }

    /**
     * @return bool
     */
    public function behavior()
    {
        return false;
    }

}