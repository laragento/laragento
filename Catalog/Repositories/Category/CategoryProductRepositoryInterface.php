<?php
/**
 * Created by PhpStorm.
 * User: KARLEN
 * Date: 08.11.2017
 * Time: 11:02
 */

namespace Laragento\Catalog\Repositories\Category;


interface CategoryProductRepositoryInterface
{
    /**
     * @param $categoryId
     * @param $productId
     */
    public function store($categoryId, $productId);

    public function storeByPath($categoryData, $productId);
}