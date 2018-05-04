<?php

namespace Laragento\Catalog\Repositories\Category;

use Laragento\Catalog\Models\Category\CategoryProduct;
use Laragento\Store\Models\StoreGroup;
use Laragento\Store\Repositories\StoreRepository;


class CategoryProductRepository implements CategoryProductRepositoryInterface
{
    protected $errors;
    protected $categoryRepository;
    protected $storeRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        StoreRepository $storeRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->storeRepository = $storeRepository;
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
     * @param $categoryData
     * @param $productId
     * @param bool $create
     * @return mixed
     */
    public function storeByPath($categoryData, $productId, $create = true)
    {
        $categories = explode("/", $categoryData['path']);

        //parent ID is AdminStore 0
        $parentId = $this->getStoreRootCategoryId($this->storeRepository->getAdminStoreId());

        $categoryPath = isset($categories[0]) ? $categories[0] : '';

        foreach ($categories as $categoryName) {
            $categoryName = trim($categoryName);

            $categoryId = CategoryRepository::getCategoryIdByName($categoryName, $storeId);

            if (!$categoryId) {
                if (!$create) {
                    print_r('    CATEGORY #>' . $path . '<# not found    ');
                    return null;
                }

                $categoryPath .= '/' . $categoryName;

                //set values extracted from path
                $categoryData['path'] = $categoryPath;
                $categoryData['name'] = $categoryName;
                $categoryData['url_key'] = str_replace(' ', '-', strtolower($categoryName));
                $categoryData['url_path'] = str_replace(' ', '-', strtolower($categoryPath));

                $category = $this->categoryRepository->store($categoryData, $parentId);
                $categoryId = $category->entity_id;
            }

            $parentId = $categoryId;
        }

        //assign product to last category in $categories array
        $this->store($parentId, $productId);

        return $parentId; //return assigned categoryId
    }

    /**
     * Get Root Category based On given StoreID
     *
     * @param $storeId
     * @return bool|int|mixed
     */
    private function getStoreRootCategoryId($storeId)
    {
        $storeRepo = new StoreRepository();

        $store = $storeRepo->getById($storeId);

        if(isset($store['group_id'])) {
            if($storeGroup = StoreGroup::whereGroupId($store['group_id'])
                ->first()) {

                if($storeGroup->root_category_id == 0) { //if 0 return default root category 1
                    return 1;
                }

                return $storeGroup->root_category_id;
            }
        }

        return false;
    }

}