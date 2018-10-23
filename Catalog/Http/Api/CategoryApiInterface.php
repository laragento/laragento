<?php
/**
 * Created by PhpStorm.
 * User: KARLEN
 * Date: 24.11.2017
 * Time: 13:23
 */

namespace Laragento\Catalog\Http\Api;


interface CategoryApiInterface
{
    /**
     * Finds a category by an identifier, products and children will be included in the response
     *
     * @param $identifier
     * @return mixed
     */
    public function first($identifier);

    /**
     * Returns all active products in the category
     *
     * @param $categoryId
     * @return mixed
     */
    public function products($categoryId);

    /**
     * Returns all sub-categories
     *
     * @param $categoryId
     * @return mixed
     */
    public function children($categoryId);


    /**
     * Returns the parent category of an category
     *
     * @param $categoryId
     * @return mixed
     */
    public function parent($categoryId);
}