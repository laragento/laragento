<?php

namespace Laragento\Catalog\Repositories\Category;

use Laragento\Catalog\Models\Category\CategoryProduct;
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
     * @param bool $create
     * @return mixed
     * @todo check and refactor
     */
    public function storeByPath($path, $productId, $storeId, $create = false)
    {
        $categories = explode("/", $path);
        $parentId = $this->getStoreRootCategory($storeId);

        foreach ($categories as $categoryName) {
            $categoryId = CategoryRepository::getCategoryIdByName(trim($categoryName), $storeId);

            if (!$categoryId) {
                if (!$create) {
                    print_r('    CATEGORY #>' . $path . '<# not found    ');
                    return null;
                }

                $category = $this->categoryRepository->store([
                    'name' => trim($categoryName),
                ], $parentId, $storeId);
                $categoryId = $category->entity_id;
            }
            $parentId = $categoryId;
        }
        if ($parentId) {
            $this->store($parentId, $productId);
        }
    }

    private function getStoreRootCategory($storeId)
    {
        $storeRepo = new StoreRepository();
        $groupId = $storeRepo->getById($storeId)['group_id'];
        $group = $storeRepo->getGroupById($groupId);

        return $group['root_category_id'];

    }

}