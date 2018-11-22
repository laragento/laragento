<?php

namespace Laragento\Indexer\Handlers;

class StockHandler implements IndexHandlerInterface
{
    /**
     * @param $productId
     * @param $productRepository
     * @param $attribute
     * @param $attributeRepository
     * @param $indexModel
     * @return int
     */
    public static function execute($productId, $productRepository, $attribute, $attributeRepository, $indexModel)
    {
        return ($productStock = $productRepository::stockByProductId($productId)) ? $productStock->qty : 0;
    }
}