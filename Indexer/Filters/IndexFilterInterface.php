<?php

namespace Laragento\Indexer\Filters;

interface IndexFilterInterface
{
    /**
     * @param $productId
     * @param $productRepository
     * @param $attributeRepository
     * @param $indexModel
     */
    public static function execute($productId, $productRepository, $attributeRepository, $indexModel);
}