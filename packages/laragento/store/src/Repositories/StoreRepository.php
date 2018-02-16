<?php

namespace Laragento\Store\Repositories;

use Laragento\Store\Models\Store;
use Laragento\Store\Models\StoreGroup;
use Laragento\Store\Models\StoreWebsite;

class StoreRepository implements StoreRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function first($identifier)
    {
        if (!is_numeric($identifier)) {
            return Store::whereCode($identifier)
                ->where('is_active', 1)
                ->first();
        }
        return $this->getById($identifier);
    }

    /**
     * {@inheritDoc}
     */
    public function forceFirst($code)
    {
        return Store::whereCode($code)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return Store::where('is_active', 1)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return Store::all();
    }

    /**
     * {@inheritDoc}
     */
    public function find()
    {
        // @todo implement method
        dd('implement find method in StoreRepository');
    }

    /**
     * {@inheritDoc}
     */
    public function store($storeData)
    {
        $store = false;
        if(isset($storeData['store_id']))
        {
            $store = Store::where(['store_id' => $storeData['store_id']])->first();
        }
        if (!$store) {
            $store = new Store($storeData);
            $store->save();
        } else {
            $store->update($storeData);
        }
        return $store;
    }

    /**
     * {@inheritDoc}
     */
    public function getList()
    {
        return $this->all();
    }

    /**
     * {@inheritDoc}
     */
    public function getActiveStoreByCode($code)
    {
        $store = $this->first($code);
        if (!$store->is_active) {
            //throw new StoreIsInactiveException();
            return false;
        }
        return $store;
    }

    /**
     * {@inheritDoc}
     */
    public function getSaveStoreIdByCode($code)
    {
        $activeStore = $this->getActiveStoreByCode($code);
        if($activeStore->getKey() != $this->getDefaultStoreId()){
            return $activeStore->getKey();
        }
        return $this->getAdminStoreId();
    }

    /**
     * {@inheritDoc}
     */
    public function getActiveStoreById($storeId)
    {
        $store = $this->getById($storeId);
        if (!$store->is_active) {
            //throw new StoreIsInactiveException();
            return false;
        }
        return $store;
    }

    /**
     * {@inheritDoc}
     */
    public function getById($storeId)
    {
        return Store::whereStoreId($storeId)->first();
    }


    /**
     * {@inheritDoc}
     */
    public function getGroupById($groupId)
    {
        return StoreGroup::whereGroupId($groupId)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getWebsiteById($websiteId)
    {
        return StoreWebsite::whereWebsiteId($websiteId)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function clean()
    {
        // TODO: Implement clean() method.
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultStoreId()
    {
        return self::DEFAULT_STORE_ID;
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultWebsiteId()
    {
        return self::DEFAULT_WEBSITE_ID;
    }

    /**
     * @inheritDoc
     */
    public function getAdminStoreId()
    {
        return self::ADMIN_STORE_ID;
    }

    /**
     * @inheritDoc
     */
    public function getAdminWebsiteId()
    {
        return self::ADMIN_WEBSITE_ID;
    }


}