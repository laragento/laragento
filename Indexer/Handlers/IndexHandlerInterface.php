<?php

namespace Laragento\Indexer\Handlers;

interface IndexHandlerInterface
{
    /**
     * @param $productId
     * @param $productRepository
     * @param $attribute
     * @param $attributeRepository
     */
    public static function execute($productId, $productRepository, $attribute, $attributeRepository);
}