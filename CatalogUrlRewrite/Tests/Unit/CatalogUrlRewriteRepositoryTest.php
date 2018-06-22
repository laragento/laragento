<?php

namespace Laragento\CatalogUrlRewrite\Tests\Unit;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Laragento\CatalogUrlRewrite\Managers\CatalogUrlRewriteManager;
use Laragento\Eav\Repositories\AttributeRepository;
use Laragento\Store\Repositories\StoreRepository;
use Tests\CreatesApplication;

class CatalogUrlRewriteRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var StoreRepository
     */
    protected $storeRepository;

    /**
     * @var CatalogUrlRewriteManager
     */
    protected $manager;


    public function setUp()
    {
        parent::setUp();
        $this->storeRepository = new StoreRepository();
        $this->manager = new CatalogUrlRewriteManager(
            new AttributeRepository()
        );

        DB::beginTransaction();
    }

    /**
     * @test
     */
    public function generate_301_category_rewrites()
    {
        $this->manager->generateUrlRewrites('category');
    }

    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}