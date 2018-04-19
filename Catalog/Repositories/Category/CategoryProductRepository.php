<?php

namespace Laragento\Catalog\Repositories\Category;

use Laragento\Catalog\Models\Category\CategoryProduct;
use Laragento\Store\Models\StoreGroup;
use Laragento\Store\Repositories\StoreRepository;


class CategoryProductRepository implements CategoryProductRepositoryInterface
{
    protected $errors;
    protected $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    }

    /**
     * @param $categoryId
     * @return mixed
     */
    public function all($categoryId)
    {
        return CategoryProduct::with('category.entities', 'products.entities')
            ->whereCategoryId($categoryId)->orderBy('position')->get();
    }

    /**
     * @param $categoryId
     * @param $productId
     * @return mixed
     */
    public function store($categoryId, $productId)
    {
        try {
            return CategoryProduct::firstOrCreate([
                'category_id' => $categoryId,
                'product_id' => $productId,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            print_r($e->getCode() . $e->getMessage());
        }
    }

    /**
     * @param $path
     * @param $productId
     * @param $storeId
     * @param bool $create
     * @return mixed
     * @todo check and refactor
     */
    public function storeByPath($path, $productId, $storeId, $create = true)
    {
        $categories = explode("/", $path);
        $parentId = $this->getStoreRootCategoryId($storeId);

        $rootCategory = $this->categoryRepository->get($parentId);
        $categoryPath = $rootCategory->path;

        foreach ($categories as $categoryName) {
            $categoryId = CategoryRepository::getCategoryIdByName(trim($categoryName), $storeId);

            if (!$categoryId) {
                if (!$create) {
                    print_r('    CATEGORY #>' . $path . '<# not found    ');
                    return null;
                }

                $category = $this->categoryRepository->store([
                    'name' => trim($categoryName),
                    'path' => $categoryPath . '/' . trim($categoryName)
                ], $parentId, $storeId);
                $categoryId = $category->entity_id;
            }

            $childCategory = $this->categoryRepository->get($categoryId);
            $categoryPath .= '/' . $childCategory->path;

            $parentId = $categoryId;
        }
        if ($parentId) {
            $this->store($parentId, $productId);
        }
    }

    private function getStoreRootCategoryId($storeId)
    {
        $storeRepo = new StoreRepository();

        $store = $storeRepo->getById($storeId);

        if(isset($store['group_id'])) {
            if($storeGroup = StoreGroup::whereGroupId($store['group_id'])
                ->first()) {

                return $storeGroup['root_category_id'];
            }
        }

        return false;
    }

}