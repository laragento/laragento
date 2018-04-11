<?php

namespace Laragento\Store\Repositories;

use Laragento\Core\Repositories\RepositoryInterface;

interface StoreRepositoryInterface extends RepositoryInterface
{
    const ADMIN_STORE_ID = 0;
    const DEFAULT_STORE_ID = 1;
    const ADMIN_WEBSITE_ID = 0;
    const DEFAULT_WEBSITE_ID = 1;

    /**
     * @param $storeData
     * @return mixed
     */
    public function store($storeData);

    /**
     * Retrieve list of all stores
     */
    public function getList();

    /**
     * Retrieve active store by code
     *
     * @param $code
     * @return mixed
     */
    public function getActiveStoreByCode($code);

    /**
     * Retrieve store where to save information
     * e.g. admin store for default store
     * explicit store for others
     *
     * @param $code
     * @return mixed
     */
    public function getSaveStoreIdByCode($code);

    /**
     * Retrieve active store by id
     *
     * @param $storeId
     * @return mixed
     */
    public function getActiveStoreById($storeId);

    /**
     * Retrieve store by id
     * @param $storeId
     * @return mixed
     * @deprecated
     */
    public function getById($storeId);

    /**
     * Retrieve group by id
     * @param $groupId
     * @return mixed
     */
    public function getGroupById($groupId);

    /**
     * @param $websiteId
     * @return mixed
     */
    public function getWebsiteById($websiteId);

    /**
     * Clear cached entities
     */
    public function clean();

    /**
     * Retrieve default store id.
     */
    public function getDefaultStoreId();

    /**
     * Retrieve default website id.
     */
    public function getDefaultWebsiteId();

    /**
     * Retrieve default store id.
     */
    public function getAdminStoreId();

    /**
     * Retrieve default website id.
     */
    public function getAdminWebsiteId();
}