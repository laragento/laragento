<?php

namespace Laragento\Indexer\Handlers;

class UrlKeyHandler implements IndexHandlerInterface
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
        return ($productSlug = $productRepository->urlKeyByProductId($productId)) ? $productSlug : uniqid();
    }
}