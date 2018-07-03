<?php

namespace Laragento\Indexer\Handlers;

class StockHandler implements IndexHandlerInterface
{
    /**
     * @param $productId
     * @param $productRepository
     * @param $attribute
     * @param $attributeRepository
     * @return int
     */
    public static function execute($productId, $productRepository, $attribute, $attributeRepository)
    {
        return ($productStock = $productRepository::stockByProductId($productId)) ? $productStock->qty : 0;
    }
}