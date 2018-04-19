<?php

namespace Laragento\Catalog\Repositories\Product;

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
    const DEFAULT_FRONTEND_CONFIG = [
        'visibility' => [self::VISIBILITY_CATALOG, self::VISIBILITY_CATALOG_SEARCH],
        'status' => ['1'],
        'child_config' => ['status' => ['1']],
    ];

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
     * @param $productData
     * @param null $config
     * @return Product
     * @internal param $behavior
     */
    public function store($productData, $config = null)
    {
        $behavior = isset($config[ImportInterface::CONFIG_BEHAVIOR]) ? $config[ImportInterface::CONFIG_BEHAVIOR] : ImportInterface::BEHAVIOR_ADD_UPDATE;

        $productOptions = [
            'attribute_set_id' => 4,
            'type_id' => $productData['type_id'],
            'sku' => $productData['sku'],
            'has_options' => 0,
            'required_options' => 0,
            'instant_buyable' => 0,
            'options_container' => "container2",
        ];

        $update = false;

        $product = Product::where('sku' , $productData['sku'])->first();

        if (!$product) {
            if (ImportInterface::BEHAVIOR_UPDATE != $behavior) {
                $product = new Product($productOptions);
                $product->save();
                //ToDo Update Website in Product-Website Relationship
                $this->saveWebsite($product, $productData['website_id']);
            } else {
                $update = true;
            }
        }

        if (!$product) {
            $productData = $this->saveImage($productData, $product->entity_id, $config);
            $this->saveCategories($productData, $product->entity_id);
            $this->saveAttributes($productData, $product, $update);
            $this->saveTierPrices($productData, $product->entity_id);

            if (!empty($this->errors)) {
                // rollback db
                dd($this->errors);
            }
        } else {
            return false;
        }

        return $product;
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
     * @param $update
     */
    public function saveAttributes($productData, $product, $update)
    {
        if (!isset($productData['store_id']) || $productData['store_id'] == null) {
            /*
             * Here we need the AdminStoreId and not the DefaultStoreId because we never save Information to the
             * default store-view. Instead we access the admin e.g. parent information.
             */
            $productData['store_id'] = $this->storeRepository->getAdminStoreId();
        }
        $this->productAttributeRepository->save($productData, $product, $update);
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
     * @param $productObj
     * @param $websiteId
     */
    public function saveWebsite($productObj, $websiteId)
    {
        if ($websiteId == null) {
            $websiteId = $this->storeRepository->getDefaultWebsiteId();
        }
        $productWebsite = new ProductWebsite([
            'product_id' => $productObj->entity_id,
            'website_id' => $websiteId
        ]);
        $productWebsite->save();
    }


}