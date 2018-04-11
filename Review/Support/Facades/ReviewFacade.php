<?php namespace Laragento\Review\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Laragento\Review\Managers\ReviewManager;

class ReviewFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return ReviewManager::class;
    }
}
