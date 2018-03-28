<?php

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;
use Illuminate\Support\Facades\DB;
use Laragento\Catalog\Support\Facades\ProductFacade;

class ProductTest extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');
        DB::beginTransaction();
    }

    /**
     * @test
     */
    public function get_product_by_product_id()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function get_newest_products()
    {
        $newest = ProductFacade::newest(4);
        $this->assertCount(4, $newest);
    }

    /**
     *
     */
    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }

}