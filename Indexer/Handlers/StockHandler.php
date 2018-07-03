<?php

namespace Laragento\Indexer\Handlers;

use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;

class StockHandler implements IndexHandlerInterface
{
    protected static $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    )
    {
        self::$productRepository = $productRepository;
    }

    /**
     * @param $productId
     * @return int
     */
    public static function execute($productId)
    {
        return ($productStock = self::$productRepository::stockByProductId($productId)) ? $productStock->qty : 0;
    }
}