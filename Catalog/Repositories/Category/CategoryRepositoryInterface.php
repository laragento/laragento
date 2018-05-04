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
     * @param $categoryData
     * @param int $parentId
     * @return
     */
    public function store($categoryData, $parentId = 0);

    /**
     * Get info about category by category id
     * @param $categoryId
     * @return
     */
    public function get($categoryId);


    /**
     * Get all products ny categoryId
     * @param $categoryId
     * @return mixed
     */
    public function products($categoryId);


    public function first($identifier);

    /**
     * Delete category by identifier
     */
    public function delete();


    public function category($categoryId);

}