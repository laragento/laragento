<?php namespace Laragento\Catalog\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Laragento\Customer\Http\Api\CustomerApi;

class CustomerFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return CustomerApi::class;
    }
}
