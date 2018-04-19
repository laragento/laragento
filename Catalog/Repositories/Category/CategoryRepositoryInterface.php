<?php
/**
 * Created by PhpStorm.
 * User: KARLEN
 * Date: 08.11.2017
 * Time: 09:27
 */

namespace Laragento\Catalog\Repositories\Category;


interface CategoryRepositoryInterface
{
    /**
     * Create category
     */
    public function store($categoryData, $parentId = 0, $storeId);

    /**
     * Get info about category by category id
     * @param $categoryId
     * @return
     */
    public function get($categoryId);


    public function first($identifier);

    /**
     * Delete category by identifier
     */
    public function delete();


    public function category($categoryId);

}