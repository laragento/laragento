<?php

namespace Laragento\Store\Tests\Unit;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Laragento\Store\Models\Store;
use Laragento\Store\Models\StoreGroup;
use Laragento\Store\Models\StoreWebsite;
use Laragento\Store\Repositories\StoreRepository;
use Tests\CreatesApplication;

abstract class AbstractRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var StoreRepository
     */
    protected $storeRepository;

    /**
     * @var StoreWebsite
     */
    protected $storeWebsite;

    /**
     * @var StoreGroup
     */
    protected $storeGroup;

    /**
     * @var Store
     */
    protected $store;


    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');
        $this->storeRepository = new StoreRepository();

        DB::beginTransaction();

        $this->initializeStoreWebsite();
        $this->initializeStoreGroup();
    }

    protected function initializeStoreWebsite()
    {
        /* create new storeWebsite */
        $this->storeWebsite = factory(StoreWebsite::class)->make();
        $this->storeWebsite->save();
    }

    protected function initializeStoreGroup()
    {
        /* create new storeGroup */
        $this->storeGroup = factory(StoreGroup::class)->make([
            'website_id' => $this->storeWebsite
        ]);
        $this->storeGroup->save();
    }

    protected function initializeStore()
    {
        /* create new store */
        $this->store = factory(Store::class)->make();
        $this->store->save();
    }

    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}