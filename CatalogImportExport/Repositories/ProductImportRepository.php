<?php

namespace Laragento\CatalogImportExport\Repositories;

use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Laragento\Catalog\Models\Product\Link\ProductLink;
use Laragento\Catalog\Models\Product\Link\ProductLinkAttributeDecimal;
use Laragento\Catalog\Models\Product\Link\ProductLinkAttributeInteger;
use Laragento\Catalog\Repositories\Inventory\InventoryRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductLinkRepository;
use Laragento\Catalog\Repositories\Product\ProductLinkRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;
use Laragento\CatalogImportExport\Http\Requests\ImportGroupedProductRequest;
use Laragento\CatalogImportExport\Http\Requests\ImportSimpleProductErrorRequest;
use Laragento\CatalogImportExport\Http\Requests\ImportSimpleProductWarningRequest;
use Laragento\ImportExport\Managers\Import\ImportInterface;
use Validator;
use Illuminate\Support\Facades\File;


class ProductImportRepository implements ProductImportRepositoryInterface
{
    const REFERENCE_ID = 'sku';

    protected $errors = [];
    protected $warnings = [];
    protected $productRepository;
    protected $productLinkRepository;
    protected $inventoryRepository;
    protected $duplicateSkus = [];
    protected $config = [];
    protected $imageRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductLinkRepositoryInterface $productLinkRepository,
        InventoryRepositoryInterface $inventoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productLinkRepository = $productLinkRepository;
        $this->inventoryRepository = $inventoryRepository;
    }

    public function import($products, $config = false)
    {
        $this->setUp();
        $this->configure($config);
        $this->execute($products);
        $errors = $this->getErrors();
        print_r($errors);
        //print_r($this->warnings);
        return $errors;
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
//        $this->behavior = $this->behavior();
//        $this->entityCode = $this->entityCode();
//        $this->transformer = $this->transformer();
//        $this->repository = $this->repository();
    }

    public function execute($products)
    {
        foreach ($products['data'] as $productData) {
            $this->saveProduct($productData);
        }
    }

    /**
     * @param $product
     * @return null
     * @todo throw exceptions
     */
    public function saveProduct($product)
    {
        if(isset($product['ignore'])){
            print_r('Product '.$product['ignore'].' is ignored');
            return null;
        }
        if (!isset($product['type_id'])) {
            print_r('Product type_id is not set');
            return null;
        }
        switch ($product['type_id']) {
            case 'simple':
                if ($this->validSimpleProduct($product)) {
                    $simpleProduct = $this->productRepository->store($product,
                        $this->config);
                    $product['entity_id'] = $simpleProduct->entity_id;
                    $this->saveInventory($product);
                }
                break;
            case 'grouped':
                if ($this->validGroupedProduct($product)) {
                    $parentProduct = $this->productRepository->store($product,
                        $this->config);
                    if ($parentProduct != null) {
                        //ToDo Trait with general Modelhelpers
                        //ToDo Check childproduct stock-status
                        $product['qty'] = 1;
                        $product['entity_id'] = $parentProduct->entity_id;

                        /**
                         * TODO here we have a problem, we can't use once an array and once an model-object
                         * if we use the data-array the entity_id is missing. If we use the model-object the
                         * qty is missing. Solution using two parameters?
                         */
                        $this->saveInventory($product);
                        $this->saveChildProducts($product, $parentProduct);
                    }

                }
                break;
            default:
                print_r('product type ' . $product['type_id'] . ' is not yet implemented');
        }
        return null;
    }

    /**
     * @param $product
     * @return bool
     */
    protected function validSimpleProduct($product)
    {
        //if(isset($this->duplicateSkus[$product->sku])){
        //      $this->duplicateSkus = [$product->sku => $this->duplicateSkus[$product->sku]+1];
        //}else{
        //      $this->duplicateSkus[$product->sku] = 0;
        //}

        if ($this->validate(new ImportSimpleProductErrorRequest(), $product, 'error')) {
            $this->validate(new ImportSimpleProductWarningRequest(), $product, 'waring');
            return true;
        }
        return false;
    }

    /**
     * @param $product
     * @return bool
     */
    protected function validGroupedProduct($product)
    {
        return $this->validate(new ImportGroupedProductRequest(), $product, 'error');
    }

    /**
     * @param $request
     * @param $reference
     * @param $logLevel
     * @return bool
     */
    protected function validate($request, $reference, $logLevel)
    {
        $element = 'product-import';
        $validator = Validator::make($reference, $request->rules());
        try {
            $validator->validate();
        } catch (ValidationException $exception) {
            //@todo
        }
        if ($validator->errors()->any()) {
            if ($logLevel == 'waring') {
                $this->warnings[$element][] = [
                    'timestamp' => Carbon::now(),
                    'reference-id' => $reference[$this::REFERENCE_ID],
                    'errors' => $validator->errors(),
                    'reference' => json_encode($reference),
                ];
            } else {
                $this->errors[$element][] = [
                    'timestamp' => Carbon::now(),
                    'reference-id' => $reference[$this::REFERENCE_ID],
                    'errors' => $validator->errors(),
                    'reference' => json_encode($reference),
                ];
            }

            foreach ($validator->errors()->all() as $error) {
                File::append(
                    storage_path('app/import-export/shop_export/status/product_status.csv'),
                    '"' . Carbon::now()
                    . '";"' . $reference[$this::REFERENCE_ID]
                    . '";"' . $error . '"'
                    . PHP_EOL);
            }
            return false;
        }
        return true;
    }


    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $product
     * @return null
     */
    public function saveInventory($product)
    {
        if ($this->config[ImportInterface::CONFIG_IGNORE_STOCK]) {
            return null;
        }
        $this->inventoryRepository->store($product);
    }

    /**
     * @param $parentProduct
     * @param $productToLink
     */
    public function saveLinks($parentProduct, $productToLink, $linkValue = 0)
    {
        $isNewProductLink = $this->productLinkRepository->store(
            $parentProduct->entity_id,
            $productToLink->entity_id,
            self::LINK_TYPE_ID,
            $linkValue);

        if ($isNewProductLink) {
            $parentProduct->children()->attach($productToLink->entity_id);
        }
    }

    /**
     * @param $newConfig
     * @todo replace with array function
     */
    public function config($newConfig)
    {
        if (empty($this->config)) {
            $this->config = $newConfig;
        }
        if ($newConfig) {
            foreach ($this->config as $configKey => $configEntry) {
                if (isset($newConfig[$configKey])) {
                    $this->config[$configKey] = $newConfig[$configKey];
                }
            }
        }
    }

    /**
     * @param $product
     * @param $parentProduct
     */
    protected function saveChildProducts($product, $parentProduct)
    {
        $productsToLink = [];
        $linkValue = 0;
        if (isset($product['simple']['data'][0])) {
            foreach ($product['simple']['data'][0] as $index => $simple) {
                if ($this->validSimpleProduct($simple)) {

                    $productToLink = $this->productRepository->store($simple,
                        $this->config);

                    $productsToLink[] = $productToLink;
                    $linkValue++;
                    $this->saveLinks($parentProduct, $productToLink, $linkValue);

                    /**
                     * TODO same problem as above (saveInventory)
                     */
                    $simple['entity_id'] = $productToLink->entity_id;
                    $this->saveInventory($simple);
                }
            }
            // $parentProduct->children()->saveMany($productsToLink); // update not insert
        }
        print_r('[ ' . $parentProduct->entity_id . ',' . $parentProduct->sku . ' ]');
    }
}