<?php

namespace Laragento\Indexer\Handlers;

use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;

class StockHandler implements IndexHandlerInterface
{
    /**
     * @param $productId
     * @param $productRepository
     * @return int
     */
    public static function execute($productId, $productRepository)
    {
        return ($productStock = $productRepository::stockByProductId($productId)) ? $productStock->qty : 0;
    }
}