<?php

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laragento\Catalog\Models\Category\Category;
use Laragento\Catalog\Models\Category\CategoryProduct;
use Laragento\Catalog\Models\Product\Product;
use Laragento\Catalog\Repositories\Category\CategoryProductRepository;
use Tests\CreatesApplication;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class CategoryProductRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var CategoryProductRepository
     */
    protected $categoryProductRepository;

    /**
     * @var Faker
     */
    protected $faker;


    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');
        $this->categoryProductRepository = $this->app->make(CategoryProductRepository::class);
        DB::beginTransaction();
    }

    /**
     * @test
     * @todo use factories
     * @todo don't use constant _id's
     */
    public function store_new_category_to_product_relation()
    {
        $category = new Category([
            'attribute_set_id' => 3,
            'parent_id' => 0,
            'path' => '',
            'position' => 1,
            'level' => 1,
            'children_count' => 0,
        ]);
        $category->save();

        $productSku = 'some-random-sku';
        $product = new Product([
            'attribute_set_id' => 4,
            'type_id' => 'simple',
            'sku' => $productSku,
            'has_options' => 0,
            'required_options' => 0,
        ]);
        $product->save();

        $this->categoryProductRepository->store($category->entity_id, $product->entity_id);
        $categoryProduct = CategoryProduct::whereCategoryId($category->entity_id)->whereProductId($product->entity_id)->first();

        $this->assertEquals($category->entity_id, $categoryProduct->category_id);
        $this->assertEquals($product->entity_id, $categoryProduct->product_id);
    }

    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}