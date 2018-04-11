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
        $this->attributeRepository = new AttributeRepository();
        $this->categoryProductRepository = new CategoryProductRepository();
        $this->imageRepository = new ImageRepository();
        $this->catalogAttributeRepository = new CatalogAttributeRepository();
        $this->storeRepository= new StoreRepository();
        $this->productAttributeRepository = new ProductAttributeRepository(
            $this->attributeRepository,
            $this->catalogAttributeRepository
        );

        $this->productRepository = new ProductRepository(
            $this->storeRepository,
            $this->imageRepository,
            $this->productAttributeRepository,
            $this->categoryProductRepository
        );
        $this->faker = new Faker;
        DB::beginTransaction();
    }

    /**
     * @test
     */

    public function getProductById()
    {
        $this->assertTrue(true);
    }

    public function testGetAttributeValueByProductIdAndAttributeCode()
    {
        $this->assertTrue(true);
//        $data = $this->productRepository->data('name', 2);
//        $this->assertEquals('SCHWALBE Rocket Ron', $data->value);
    }

    public function testStoreNewProduct()
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

        $this->storeProduct($productData);
    }

    public function testUpdateProduct()
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
            'color' => 1,
        ];

        $this->storeProduct($productData);

        $productData = [
            'sku' => $sku,
            'name' => 'blasdf asdfasdf',
            'type_id' => 'simple',
            'store_id' => 0,
            'website_id' => 0,
            'description' => 'afwef',
            'short_description' => 'aasdfsdf',
            'color' => 1,
        ];

        $this->storeProduct($productData);

//        $this->storeProduct($productData);
    }


    /**
     * @param $productData
     */
    public function storeProduct($productData)
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