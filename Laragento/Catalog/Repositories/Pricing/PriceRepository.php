<?php

namespace Laragento\Catalog\Repositories\Pricing;

use Laragento\Catalog\Models\Product\Entity\Decimal;

class PriceRepository implements PriceRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public static function regularPrice($productId)
    {
        $price = Decimal::where('attribute_id',77)->where('entity_id',$productId)->first();
        if(!$price)
        {
            return 0.0000;
        }
        return $price->value;
    }

    /**
     * {@inheritDoc}
     */
    public static function specialPrice($productId)
    {
        $price = Decimal::where('attribute_id',78)->where('entity_id',$productId)->first();
        if(!$price)
        {
            return false;
        }
        return $price->value;
    }
}