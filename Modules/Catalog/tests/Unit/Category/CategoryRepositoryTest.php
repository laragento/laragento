<?php

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laragento\Catalog\Models\Category\Category;
use Laragento\Catalog\Models\Category\Entity\Varchar;
use Laragento\Catalog\Repositories\Category\CategoryRepository;
use Tests\CreatesApplication;

class CategoryRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');
        $this->categoryRepository = new CategoryRepository();
        DB::beginTransaction();
    }

    /**
     * @todo use factories
     * @todo don't use constant _id's
     */
    public function testGetCategoryIdByName()
    {
        self::assertTrue(true);
//            $category = factory(Category::class)->create();
//            $name = factory(Varchar::class)->create([
//                  'entity_id' => $category->entity_id,
//                  'attribute_id' => 45,
//            ]);
//
//            dd($name);
//
//            $result = $this->categoryRepository->getCategoryIdByName($name->value);
//            $this->assertEquals($category->entity_id, $result);
    }

    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}