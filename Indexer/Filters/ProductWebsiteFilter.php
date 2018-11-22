<?php

namespace Laragento\Indexer\Filters;

use Laragento\Catalog\Models\Product\ProductWebsite;

class ProductWebsiteFilter implements IndexFilterInterface
{
    /**
     * @param $productId
     * @param $productRepository
     * @param $attributeRepository
     * @param $indexModel
     * @return int
     */
    public static function execute($productId, $productRepository, $attributeRepository, $indexModel)
    {
        //check if product present in current WebsiteID
        return ProductWebsite::whereProductId($productId)
            ->whereWebsiteId($indexModel->store_id)
            ->first() ? true : false;
    }
}