<?php
/**
 * Created by PhpStorm.
 * User: KARLEN
 * Date: 24.11.2017
 * Time: 13:25
 */

namespace Laragento\Catalog\Http\Api;


interface ProductApiInterface
{
    /**
     * Returns an product for a given product identifier.
     *
     * @param $identifier
     * @return mixed
     */
    public function first($identifier);

    /**
     * Returns attribute list for a given attribute set
     *
     * @param $attributeSetId
     * @return mixed
     */
    public function attributeList($attributeSetId);

    /**
     * Returns attributes with values for a given product.
     *
     * @param $productId
     * @return mixed
     */
    public function attributeListWithValues($productId);

    /**
     * The 4 newest products from catalog will be returned.
     *
     * @param $limit
     * @return mixed
     */
    public function newest($limit);


    /**
     * Save the Product
     *
     * @param $request
     * @return mixed
     */
    public function store($request);


    /**
     * @param $sku
     * @return mixed
     */
    public function parentsBySku($sku);


    /**
     * @param string $sku
     * @return integer
     */
    public function getIdBySku($sku);
}