<?php namespace Laragento\Catalog\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Laragento\Catalog\Repositories\Product\ProductRepository;

class ProductFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return ProductRepository::class;
    }
}
