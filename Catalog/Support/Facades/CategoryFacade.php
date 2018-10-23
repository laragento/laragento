<?php namespace Laragento\Catalog\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Laragento\Catalog\Repositories\Category\CategoryRepository;

class CategoryFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return CategoryRepository::class;
    }
}
