<?php

namespace Laragento\Catalog\Managers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Laragento\Catalog\Repositories\Category\CategoryAttributeRepositoryInterface;
use Laragento\Catalog\Repositories\Category\CategoryRepositoryInterface;
use Laragento\Indexer\Models\CategoryIndex;
use Laragento\Indexer\Models\ProductIndex;

class CategoryManager {
    protected $categoryRepository;
    protected $categoryAttributeRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CategoryAttributeRepositoryInterface $categoryAttributeRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryAttributeRepository = $categoryAttributeRepository;
    }

    /**
     * map category index data with additional data for view
     *
     * @param $categoryData
     * @return mixed
     */
    public function mapCategoryData($categoryData) {
        $categoryData['path'] = '/' . ltrim(strstr($categoryData['url_path'], '/'), '/');

        if($categoryData['image'] != '') {
            $categoryData['image'] = config('catalog.magento_category_image_path') . $categoryData['image'];
        } else {
            //placeholderimage
            $categoryData['image'] = url(config('catalog.placeholder_image_path'));
        }


        return $categoryData;
    }

    /**
     * @param $categoryId
     * @param $storeId
     * @return mixed
     */
    public function getRelatedProducts($categoryId, $storeId)
    {
        $relatedProducts = ProductIndex::join('catalog_category_product', 'lg_catalog_product_index.product_id', '=',
            'catalog_category_product.product_id')
            ->where('catalog_category_product.category_id', '=', $categoryId)
            ->whereStatus(true)
            ->whereStoreId($storeId);

        return $relatedProducts;
    }

    /**
     * Get back store Category tree for all pages
     * @param $storeId
     * @param $categorySorting
     * @return array|mixed
     */
    public function getStoreCategoryTree($storeId, $categorySorting) {
        if(config('catalog.caching')) {
            $sortedCategories = Cache::get($storeId . '-storecategorytree');
            if($sortedCategories != null) {
                return $sortedCategories;
            }
        }

        //get root category
        $categoryIndex = CategoryIndex::with([
            'category.children.indexCategory.category.children.indexCategory',
        ])->whereStoreId($storeId);

        if($storeId == 1) {
            $categoryIndex->whereName('Amagino');
        }

        $categoryIndex = $categoryIndex->first();

        if(!$categoryIndex) {
            Log::error('could not find root category for storeId:' . $storeId);
            abort(500, 'could not find root category for storeId:' . $storeId);
        }

        //sort category data
        $sortedCategories = [];

        //level 1
        $categoryChildren = $categoryIndex->category->children;

        foreach($categorySorting as $name) {
            $category = $categoryChildren->filter(function($categoryChild) use($name) {
                return $categoryChild->indexCategory->name == $name;
            })->first();


            if($category) {
                $subCategories = [];
                $subCategoryChildren = $category->indexCategory->category->children->sortBy(function ($subCategoryChild) {
                    return $subCategoryChild->indexCategory->name;
                });

                foreach($subCategoryChildren as $subCategoryChild) {
                    $subCategories[] = $this->mapCategoryData($subCategoryChild->indexCategory->toArray());
                }

                $sortedCategories[] = [
                    'data' => $this->mapCategoryData($category->indexCategory->toArray()),
                    'subCategories' => $subCategories
                ];
            }
        }

        if(config('catalog.caching')) {
            Cache::forever($storeId . '-storecategorytree', $sortedCategories);
        }

        return $sortedCategories;
    }
}