<?php namespace Laragento\Store\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Laragento\Store\Managers\StoreManager;

class StoreFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return StoreManager::class;
    }
}
