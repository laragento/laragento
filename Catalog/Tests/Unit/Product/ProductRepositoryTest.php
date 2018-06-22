<?php

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;
use Laragento\Catalog\Repositories\Category\CategoryProductRepository;
use Laragento\Catalog\Repositories\Media\ImageRepository;
use Laragento\Catalog\Repositories\Product\ProductAttributeRepository;
use Laragento\Catalog\Repositories\Product\ProductRepository;
use Laragento\Eav\Repositories\AttributeRepository;
use Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepository;
use Laragento\Store\Repositories\StoreRepository;
use Tests\CreatesApplication;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class ProductRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var Faker
     */
    protected $faker;

    /**
     * @var ProductAttributeRepository
     */
    protected $productAttributeRepository;

    /**
     * @var CategoryProductRepository
     */
    protected $categoryProductRepository;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var AttributeRepository
     */
    protected $attributeRepository;

    /**
     * @var StoreRepository
     */
    protected $storeRepository;

    /**
     * @var ImageRepository
     */
    protected $imageRepository;

    /**
     * @var CatalogAttributeRepository
     */
    protected $catalogAttributeRepository;


    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');
        $this->productRepository =  $this->app->make(ProductRepository::class);
        $this->productAttributeRepository =  $this->app->make(ProductAttributeRepository::class);
        $this->faker = new Faker;
        DB::beginTransaction();
    }

    /**
     * @test
     */
    public function get_product_by_id()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function get_attribute_value_by_product_id_and_attribute_code()
    {
        $this->assertTrue(true);
//        $data = $this->productRepository->data('name', 2);
//        $this->assertEquals('SCHWALBE Rocket Ron', $data->value);
    }

    /**
     * @test
     */
    public function store_new_product()
    {
        $this->assertTrue(true);
////        $tierPrices = [
////           '1' => [
////               'customer_group_id' => 0,
////               'qty' => 100,
////               'value' => 5,
////               'percentage_value' => null,
////               'website_id' => 0
////           ]
////        ];
//
//        $name = $this->faker->word;
//        dd(name);
        $sku = Str::slug('Some radom sku');
        $productData = [
            'sku' => $sku,
            'name' => 'blasdf asdfasdf',
            'type_id' => 'simple',
            'store_id' => 0,
            'website_id' => 0,
            'description' => 'asdfasdf asdfasdfas fasd fasd',
            'short_description' => 'asdfasdf asdfasdf',
            'color' => 1,
        ];

        //$this->storeProduct($productData);
    }

    /**
     * @test
     */
    public function update_product()
    {
        $this->assertTrue(true);

        $sku = Str::slug('Some random sku');
        $productData = [
            'sku' => $sku,
            'name' => 'blasdf asdfasdf',
            'type_id' => 'simple',
            'website_id' => 0,
            'store_id' => 0,
            'description' => 'asdfasdf asdfasdfas fasd fasd',
            'short_description' => 'asdfasdf asdfasdf',
        ];

        $this->storeProduct($productData);

        $productData = [
            'sku' => $sku,
            'name' => 'blasdf asdfasdf',
            'type_id' => 'simple',
            'store_id' => 0,
            'website_id' => 0,
            'description' => 'afwef',
            'short_description' => 'aasdfsdf'
        ];

        $this->storeProduct($productData);
    }


    /**
     * @param $productData
     * @throws Exception
     */
    protected function storeProduct($productData)
    {
        $this->productRepository->store($productData);
        $product = $this->productRepository::productBySku($productData['sku']);
        $this->assertEquals($productData['sku'], $product->sku);

        foreach ($productData as $key => $proData) {
            if ($key == 'sku') {
                continue;
            }
            if ($key == 'type_id') {
                continue;
            }
            if ($key == 'website_id') {
                continue;
            }
            if ($key == 'store_id') {
                continue;
            }
            $data = $this->productAttributeRepository->data($key, $product->entity_id);
            $this->assertEquals($proData, $data->value);
        }
        //ToDo: make the Testoutput more verbose, using this fwrite/STDERR
        //fwrite(STDERR, print_r($product->entity_id, true));
    }

    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}