<?php

namespace Laragento\Indexer\Filters;


use Laragento\Catalog\Models\Category\Category;
use Laragento\Store\Models\StoreGroup;

class CategoryWebsiteFilter implements IndexFilterInterface
{
    /**
     * @param $categoryId
     * @param $productRepository
     * @param $attributeRepository
     * @param $indexModel
     * @return int
     */
    public static function execute($categoryId, $productRepository, $attributeRepository, $indexModel)
    {
        //check if root-category present in current WebsiteID

        //get root category of category
        if($category = Category::whereEntityId($categoryId)
            ->first()) {

            $paths = explode('/', $category->path);
            //check if path 2 is present in store group
            if(isset($paths[1])) {
                $rootCategoryId = $paths[1];

                if($storeGroup = StoreGroup::whereRootCategoryId($rootCategoryId)->first()) {
                    //default store id must be same as store id
                    if($storeGroup->default_store_id == $indexModel->store_id) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}