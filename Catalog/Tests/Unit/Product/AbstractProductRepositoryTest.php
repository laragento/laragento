<?php

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laragento\Catalog\Models\Product\Link\ProductLink;
use Laragento\Catalog\Models\Product\Product;
use Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepository;
use Laragento\Catalog\Repositories\Product\ProductAttributeRepository;
use Laragento\Catalog\Repositories\Product\ProductAttributeRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductLinkRepository;
use Laragento\Catalog\Repositories\Product\ProductLinkRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductRepository;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;
use Laragento\Eav\Models\Attribute;
use Illuminate\Support\Facades\DB;
use Laragento\Eav\Repositories\AttributeRepository;
use Tests\CreatesApplication;

abstract class AbstractProductRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var AttributeRepository
     */
    protected $attributeRepository;

    /**
     * @var ProductAttributeRepository
     */
    protected $productAttributeRepository;

    /**
     * @var CatalogAttributeRepository
     */
    protected $catalogAttributeRepository;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var ProductLinkRepository
     */
    protected $productLinkRepository;

    /**
     * @var Product
     */
    protected $simpleProduct;


    /**
     * @var Product
     */
    protected $upSellProduct;

    /**
     * @var Attribute
     */
    protected $attribute;

    /**
     * @array
     */
    protected $entityArray;

    /**
     * @var Faker
     */
    protected $faker;


    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker\Factory::create();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');

        $this->attributeRepository = new AttributeRepository();
        $this->catalogAttributeRepository = new CatalogAttributeRepository();
        $this->productAttributeRepository = $this->app->make(ProductAttributeRepositoryInterface::class);
        $this->productRepository = $this->app->make(ProductRepositoryInterface::class);
        $this->productLinkRepository = $this->app->make(ProductLinkRepositoryInterface::class);
        DB::beginTransaction();

        $this->initializeSimpleProduct();
        $this->initializeUpsell();
    }

    protected function initializeSimpleProduct()
    {
        /* create new product */
        $this->simpleProduct = factory(Product::class)->states('simple')->create();
        $this->simpleProduct->save();
    }

    protected function initializeUpsell()
    {
        $this->upSellProduct = factory(Product::class)->states('simple')->create();
        $upSellLink = factory(ProductLink::class)->states('up_sell')->create(
            [
                'product_id' => $this->simpleProduct->getKey(),
                'linked_product_id' => $this->upSellProduct->getKey(),
            ]
        );
        $upSellLink->save();
        $this->fakeProductAttributes($this->upSellProduct->sku);
    }

    protected function fakeProductAttributes($sku)
    {
        $this->productRepository->store([
            'sku' => $sku,
            'website_id' => 1,
            'store_id' => 1,
            'status' => 1,
            'product_online' => 1,
            'position' => 1,
            'weight' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 2000),
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 2000),
            //'tier_prices' => $this->currentTierPrices,
            //'special_price' => $this->price((string)$simple->special_price),
            //'special_from_date' => $this->specialDate((string)$simple->special_from_date),
            //'special_to_date' => $this->specialDate((string)$simple->special_to_date),
            'qty' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'max_sale_qty' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'tax' => (double)7.7,
            'url_key' => substr($this->faker->unique()->slug,0,20),
            'name' => (string)$this->faker->sentence($nbWords = 3, $variableNbWords = false),
            'meta_title' => (string)$this->faker->sentence($nbWords = 3, $variableNbWords = false),
            'meta_description' => '',
            'meta_keyword' => '',
            'country_of_manufacture' => 'CH',
            'visibility' => ProductRepositoryInterface::VISIBILITY_NOT_VISIBLE_INDIVIDUALLY,
            'quantity_and_stock_status' => 1,
            'gift_message_available' => 2,
            'color' => 1,
            'options_container' => "container2",
        ]);
    }


    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}