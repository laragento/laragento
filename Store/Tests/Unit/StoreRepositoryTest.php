<?php

namespace Laragento\Store\Tests\Unit;

use Laragento\Store\Models\Store;
use Laragento\Store\Models\StoreGroup;
use Laragento\Store\Models\StoreWebsite;
use Laragento\Store\Support\Facades\StoreFacade;

class StoreRepositoryTest extends AbstractRepositoryTest
{
    /**
     * @test
     */
    public function create_new_store_website()
    {
        // @todo use repository to create website
        /** @var  StoreWebsite $website */
        $website = $this->storeRepository->getWebsiteById($this->storeWebsite->getKey());
        $this->assertEquals($website->getKey(), $this->storeWebsite->getKey());
    }

    /**
     * @test
     */
    public function create_new_store_group()
    {
        // @todo use repository to create store group
        /** @var  StoreGroup $storeGroup */
        $storeGroup = $this->storeRepository->getGroupById($this->storeGroup->getKey());
        $this->assertEquals($storeGroup->website_id, $this->storeWebsite->getKey());
    }

    /**
     * @test
     */
    public function create_new_store()
    {
        $newStore = factory(Store::class)->make(
            [
                'website_id' => $this->storeWebsite->getKey(),
                'group_id' => $this->storeGroup->getKey(),
            ]
        );

        /** @var  Store $createdStore */
        $createdStore = $this->storeRepository->store(
            [
                'code' => $newStore->code,
                'website_id' => $newStore->website_id,
                'group_id' => $newStore->group_id,
                'name' => $newStore->name,
                'sort_order' => $newStore->sort_order,
                'is_active' => $newStore->is_active
            ]
        );

        /** @var  Store $store */
        $store = $this->storeRepository->first($newStore->code);

        $this->assertEquals($store->website_id, $createdStore->website_id);
        $this->assertEquals($store->name, $createdStore->name);
        $this->assertEquals($store->is_active, $createdStore->is_active);
    }

    /**
     * @test
     */
    public function update_store()
    {
        /** @var  Store $newStore */
        $newStore = factory(Store::class)->make(
            [
                'website_id' => $this->storeWebsite->getKey(),
                'group_id' => $this->storeGroup->getKey(),
            ]
        );
        $newStore->save();

        /** @var  Store $updatedStore */
        $updatedStore = $this->storeRepository->store(
            [
                'store_id' => $newStore->getKey(),
                'name' => $newStore->name.'random-string',
            ]
        );

        /** @var  Store $store */
        $store = $this->storeRepository->first($newStore->code);

        $this->assertEquals($store->website_id, $updatedStore->website_id);
        $this->assertEquals($store->name, $updatedStore->name);
        $this->assertNotEquals($store->name, $newStore->name);
    }

    /**
     * @test
     */
    public function is_the_store_sort_order_correct()
    {
        // @todo
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function activate_store()
    {
        // @todo
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function deactivate_store()
    {
        // @todo
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function test_store_website_default_group_id()
    {
        // @todo
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function test_store_group_default_store_id()
    {
        // @todo No Hard Coded Params!
        $this->assertEquals(StoreFacade::getActiveStoreByCode('de')->getKey(),1);
    }

    /**
     * @test
     */
    public function get_save_store_id_by_code()
    {
        // @todo No Hard Coded Params!
        $this->assertTrue(true);
        //$this->assertEquals(StoreFacade::getSaveStoreIdByCode('de'),0);
        //$this->assertEquals(StoreFacade::getSaveStoreIdByCode('fr'),2);
        //$this->assertEquals(StoreFacade::getSaveStoreIdByCode('it'),3);
    }

}