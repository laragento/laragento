<?php

namespace Laragento\Catalog\Repositories\Product;

use Laragento\Catalog\Models\Inventory\StockItem;
use Laragento\Catalog\Models\Inventory\StockStatus;
use Laragento\Catalog\Models\Product\Entity\Tierprice;
use Laragento\Catalog\Models\Product\Entity\Varchar;
use Laragento\Catalog\Models\Product\Product;
use Laragento\Catalog\Models\Product\ProductWebsite;
use Laragento\Catalog\Repositories\Category\CategoryProductRepositoryInterface;
use Laragento\Catalog\Repositories\Media\ImageRepositoryInterface;
use Laragento\ImportExport\Managers\Import\ImportInterface;
use Laragento\Store\Repositories\StoreRepositoryInterface;


class ProductRepository implements ProductRepositoryInterface
{
    protected $errors;
    protected $imageRepository;
    protected $storeRepository;
    protected $productAttributeRepository;
    protected $categoryProductRepository;

    public function __construct(
        StoreRepositoryInterface $storeRepository,
        ImageRepositoryInterface $imageRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository,
        CategoryProductRepositoryInterface $categoryProductRepository
    ) {
        $this->storeRepository = $storeRepository;
        $this->imageRepository = $imageRepository;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->categoryProductRepository = $categoryProductRepository;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return Product::whereIsActive(1)
            ->get();
    }

    /**
     * @param $identifier
     * @return \Illuminate\Database\Eloquent\Model|ProductRepository|null
     */
    public static function first($identifier)
    {
        return self::product($identifier);
    }

    /**
     * @param $identifier
     * @return \Illuminate\Database\Eloquent\Model|ProductRepository|null
     */
    public function find($identifier)
    {
        return self::product($identifier);
    }


    /**
     * @param $identifier
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public static function product($identifier)
    {
        if (!is_numeric($identifier)) {
            $identifier = self::getIdByUrlKey($identifier);
        }

        return Product::with([
            'categories.entities.attribute',
            'entities.attribute',
            'children.entities.attribute',
            //'links',
        ])->where(['entity_id' => $identifier])->first();
    }

    /**
     * @param $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function newest($limit)
    {
        return Product::with([
            'entities.attribute',
        ])
            ->orderBy('entity_id', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * @param $urlKey
     * @return mixed
     */
    public static function getIdByUrlKey($urlKey)
    {
        return Varchar::whereValue($urlKey)
            ->whereAttributeId(119)
            ->whereStoreId(0)
            ->firstOrFail()
            ->entity_id;
    }


    /**
     * @param $sku
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public static function productBySku($sku)
    {
        return Product::with(
            'categories.entities',
            'entities.attribute',
            'children.entities.attribute')
            ->where('sku', $sku)
            ->first();
    }

    /**
     * @param $sku
     * @return Integer
     */
    public static function getIdBySku($sku)
    {
        $product = Product::where('sku',$sku)->first();
        if (!$product) {
            return null;
        }
        return $product->entity_id;
    }

    /**
     * @param $sku
     * @return mixed|null
     */
    public static function parentsBySku($sku)
    {
        // @TODO A Product has only one parent, right?
        $product = Product::with('parents')->where('sku',$sku)->first();
        if (!$product) {
            return null;
        }
        return $product;
    }

    /**
     * @param $productId
     * @param int $stockId
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function stockByProductId($productId, $stockId = 1) {
        return StockItem::whereProductId($productId)
            ->whereStockId($stockId)
            ->first();
    }

    /**
     * @param $productData
     * @return Product
     * @internal param $behavior
     */
    public function store($productData)
    {
        //check if product already exists, if not create new db entry
        $product = Product::where('sku' , $productData['sku'])->first();
        if (!$product) {
            print 'create new product' . "\n";
            $product = Product::create([
                'attribute_set_id' => 4,
                'type_id' => $productData['type_id'],
                'sku' => $productData['sku'],
                'has_options' => 0,
                'required_options' => 0,
                'instant_buyable' => 0,
                'options_container' => "container2",
            ]);
        }

        if ($product) {
            //update product website relations{
            $this->saveWebsites($product, $productData['websites']);
            $this->saveStock($product, $productData['stock'], $productData['websites']);

            //$productData = $this->saveImage($productData, $product->entity_id, $config); //TODO refactor
            $this->saveCategories($productData, $product->entity_id);
            $this->saveAttributes($productData, $product);
            $this->saveTierPrices($productData, $product->entity_id);

            if (!empty($this->errors)) {
                // rollback db
                dd($this->errors);
            }

            return $product;
        }

        return false;
    }

    /**
     * @param $productData
     * @param $productId
     * @param $config
     * @return mixed
     */
    protected function saveImage($productData, $productId, $config)
    {
        // @ToDo No ImportThings here
        $storeMedia = isset($config[ImportInterface::CONFIG_STORE_MEDIADATA_ON_IMPORT]) ? $config[ImportInterface::CONFIG_STORE_MEDIADATA_ON_IMPORT] : true;

        if (!$storeMedia) {
            return $productData;
        }

        // @ToDo Replace config keys with constants?
        $links = [
            'sourcepath' => $config['productimport-media-sourcepath'],
            'targetpath' => $config['productimport-media-targetpath']
        ];

        $image = false;
        $imageName = '';
        //print_r($product);
        if (isset($productData['name'])) {
            $imageName = $productData['name'];
        }

        if (isset($productData['image'])) {
            $image = $this->imageRepository->saveImage($productData['image'], $productId, $imageName, $links);
        }
        if (isset($productData['images'])) {
            $image = $this->imageRepository->saveImages($productData['images'], $productId, $imageName, $links);
        }

        if ($image) {
            $productData['image'] = $image;
            $productData['small_image'] = $image;
            $productData['thumbnail'] = $image;
            $productData['image_label'] = $imageName;
        }
        return $productData;
    }


    /**
     * @param $productData
     * @param $product
     */
    public function saveAttributes($productData, $product)
    {
        if (!isset($productData['store_id']) || $productData['store_id'] == null) {
            /*
             * Here we need the AdminStoreId and not the DefaultStoreId because we never save Information to the
             * default store-view. Instead we access the admin e.g. parent information.
             */
            $productData['store_id'] = $this->storeRepository->getAdminStoreId();
        }
        $this->productAttributeRepository->save($productData, $product);
    }


    /**
     * @param $productData
     * @param $productId
     */
    public function saveTierPrices($productData, $productId)
    {
        if (isset($productData['tier_prices'])) {

            $keepArray = [];
            foreach ($productData['tier_prices'] as $tierPriceData) {
                $currentValue = $tierPriceData['value'];
                $tierPriceData = [
                    'entity_id' => $productId,
                    'all_groups' => $tierPriceData['all_groups'],
                    'customer_group_id' => 0,
                    'qty' => $tierPriceData['qty'],
                    'percentage_value' => null,
                    'website_id' => 0,
                ];
                $tierPrice = Tierprice::where($tierPriceData)->first();

                $tierPriceData['value'] = $currentValue;
                if (!$tierPrice) {
                    $tierPrice = new Tierprice($tierPriceData);
                    $tierPrice->save();
                } else {
                    $tierPrice->update($tierPriceData);
                }
                $keepArray[] = $tierPrice->getKey();
            }

            $tierPrices = Tierprice::where('entity_id', $productId)->get();
            foreach ($tierPrices as $tPrice)
            {
                if(!in_array($tPrice->getKey(),$keepArray)){
                    Tierprice::where('value_id', $tPrice->getKey())->delete();
                }
            }
        }
    }

    /**
     * @param $productData
     * @param $productId
     * @return null
     */
    public function saveCategories($productData, $productId)
    {
        if (!isset($productData['categories'])) {
            return null;
        }
        /**
         * Keep in mind that information shall be saved in the AdminStore and not in the default language. The default
         * languages information mustn't be touched.
         */
        $storeId = !isset($productData['store_id']) || $productData['store_id'] == null ? $this->storeRepository->getAdminStoreId() : $productData['store_id'];

        foreach($productData['categories'] as $category) {
            $this->categoryProductRepository->storeByPath($category, $productId, $storeId);
        }
    }

    /**
     * Save Websites <-> Product relationship
     *
     * @param $product
     * @param $websites
     * @return bool
     */
    public function saveWebsites($product, $websites)
    {
        $syncedProductWebsites = [];

        foreach ($websites as $websiteId) {
            $productWebsite = ProductWebsite::firstOrCreate([
                'product_id' => $product->entity_id,
                'website_id' => $websiteId
            ]);

            if(!$productWebsite) {
                return false;
            }

            $syncedProductWebsites[] = $productWebsite->website_id;
        }

        //remove old website_id entries
        ProductWebsite::whereProductId($product->entity_id)
            ->whereNotIn('website_id', $syncedProductWebsites)
            ->delete();

        return true;
    }

    /**
     * Save Stock for Product
     *
     * @param $product
     * @param $stock
     * @param $websites
     */
    public function saveStock($product, $stock, $websites) {
        $stockItem = StockItem::firstOrNew([
            'product_id' => $product->entity_id,
            'stock_id' => isset($stock['stock_id']) ? $stock['stock_id'] : 1
        ]);

        $stockItem->website_id = isset($websites[0]) ? $websites[0] : 1;
        $stockItem->qty = isset($stock['qty']) ? $stock['qty'] : 0;
        $stockItem->min_qty = isset($stock['min_qty']) ? $stock['min_qty'] : 0;
        $stockItem->use_config_min_qty = isset($stock['use_config_min_qty']) ? $stock['use_config_min_qty'] : 1;
        $stockItem->is_qty_decimal = isset($stock['is_qty_decimal']) ? $stock['is_qty_decimal'] : 0;
        $stockItem->backorders = isset($stock['backorders']) ? $stock['backorders'] : 0;
        $stockItem->use_config_backorders = isset($stock['use_config_backorders']) ? $stock['use_config_backorders'] : 1;
        $stockItem->min_sale_qty = isset($stock['min_sale_qty']) ? $stock['min_sale_qty'] : 1;
        $stockItem->use_config_min_sale_qty = isset($stock['use_config_min_sale_qty']) ? $stock['use_config_min_sale_qty'] : 1;
        $stockItem->max_sale_qty = isset($stock['max_sale_qty']) ? $stock['max_sale_qty'] : 0;
        $stockItem->use_config_max_sale_qty = isset($stock['use_config_max_sale_qty']) ? $stock['use_config_max_sale_qty'] : 1;
        $stockItem->is_in_stock = isset($stock['is_in_stock']) ? $stock['is_in_stock'] : 1;
        $stockItem->low_stock_date = isset($stock['low_stock_date']) ? $stock['low_stock_date'] : null;
        $stockItem->notify_stock_qty = isset($stock['notify_stock_qty']) ? $stock['notify_stock_qty'] : null;
        $stockItem->use_config_notify_stock_qty = isset($stock['use_config_notify_stock_qty']) ? $stock['use_config_notify_stock_qty'] : 1;
        $stockItem->manage_stock = isset($stock['manage_stock']) ? $stock['manage_stock'] : 0;
        $stockItem->use_config_manage_stock = isset($stock['use_config_manage_stock']) ? $stock['use_config_manage_stock'] : 1;
        $stockItem->stock_status_changed_auto = isset($stock['stock_status_changed_auto']) ? $stock['stock_status_changed_auto'] : 0;
        $stockItem->use_config_qty_increments = isset($stock['use_config_qty_increments']) ? $stock['use_config_qty_increments'] : 1;
        $stockItem->qty_increments = isset($stock['qty_increments']) ? $stock['qty_increments'] : 0;
        $stockItem->use_config_enable_qty_inc = isset($stock['use_config_enable_qty_inc']) ? $stock['use_config_enable_qty_inc'] : 1;
        $stockItem->enable_qty_increments = isset($stock['enable_qty_increments']) ? $stock['enable_qty_increments'] : 0;
        $stockItem->is_decimal_divided = isset($stock['is_decimal_divided']) ? $stock['is_decimal_divided'] : 0;

        $stockItem->save();
    }
}