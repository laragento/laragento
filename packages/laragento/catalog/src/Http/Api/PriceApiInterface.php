<?php
/**
 * Created by PhpStorm.
 * User: KARLEN
 * Date: 24.11.2017
 * Time: 13:25
 */

namespace Laragento\Catalog\Http\Api;


interface PriceApiInterface
{

    /**
     * Returns the price of a product as it is entered in backend
     * TODO is that correct?
     *
     * @param $productId
     * @return float|bool
     */
    public function getBasePrice($productId);

    /**
     * Returns the price of the product without any special offer
     * the price is converted to frontend tax settings and current currency
     * TODO is that correct?
     *
     * @param $productId
     * @return float|bool
     */
    public function getRegularPrice($productId);

    /**
     * Returns the sales price when it is active
     *
     * @param $productId
     * @return float|bool
     */
    public function getSpecialPrice($productId);
}