<?php

namespace Laragento\Catalog\Repositories\Pricing;

interface PriceRepositoryInterface
{
    /**
     * @param $productId
     * @return float
     */
    public static function regularPrice($productId);

    /**
     * @param $productId
     * @return float|bool
     */
    public static function specialPrice($productId);
}