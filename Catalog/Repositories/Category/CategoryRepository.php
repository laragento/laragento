<?php

namespace Laragento\Catalog\Repositories\Category;

use Laragento\Catalog\Models\Category\Category;
use Laragento\Catalog\Models\Category\Entity\Integer;
use Laragento\Catalog\Models\Category\Entity\Varchar;
use Laragento\Store\Repositories\StoreRepositoryInterface;


class CategoryRepository implements CategoryRepositoryInterface
{
    protected $errors;
    protected $storeRepository;
    protected $categoryAttributeRepository;

    public function __construct(
        StoreRepositoryInterface $storeRepository,
        CategoryAttributeRepositoryInterface $categoryAttributeRepository
    ) {
        $this->storeRepository = $storeRepository;
        $this->categoryAttributeRepository = $categoryAttributeRepository;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return Category::with('children.entities', 'entities')->get();
    }

    /**
     * @param $level
     * @return mixed
     */
    public function allByLevel($level)
    {
        return Category::with('children.entities', 'entities')
            ->whereLevel($level)->get();
    }

    /**
     * @param $categoryId
     * @return mixed
     */
    public function category($categoryId)
    {
        return Category::with(
            'parent',
            'products.entities.attribute',
            'children.entities.attribute',
            'entities.attribute')
            ->whereEntityId($categoryId)->first();
    }

    /**
     * @param $identifier
     * @return mixed
     */
    public function first($identifier)
    {
        return $this->category($identifier);
    }

    /**
     * @param $categoryId
     * @return mixed
     */
    public function children($categoryId)
    {
        return Category::with(
            'children.entities.attribute'
        )->whereEntityId($categoryId)->first();
    }


    /**
     * @param $categoryId
     * @return mixed
     */
    public function products($categoryId)
    {
        return Category::with(
            'products.entities.attribute'
        )->whereEntityId($categoryId)->first();
    }

    /**
     * @param $categoryId
     */
    public function parent($categoryId)
    {
        return Category::with(
            'parent.entities.attribute'
        )->whereEntityId($categoryId)->first();
    }

    /**
     * @param $categoryName
     * @param int $storeId
     * @param int $parentCategoryId
     * @return null
     */
    public static function getCategoryIdByName($categoryName, $storeId = 0, $parentCategoryId = 0)
    {
        //return first category
        if($parentCategoryId == 0) {
            $entity = Varchar::whereValue($categoryName)
                ->whereStoreId($storeId)
                ->whereAttributeId(45)
                ->first();

            return isset($entity) ? $entity->entity_id : null;
        }

        //get all categories by name
        $entities = Varchar::whereValue($categoryName)
            ->whereStoreId($storeId)
            ->whereAttributeId(45)
            ->get();

        foreach($entities as $entity) {
            //check if categoryId matches parent, if yes return ID
            if($category = Category::whereEntityId($entity->entity_id)
                ->whereParentId($parentCategoryId)
                ->first()) {

                return $category->entity_id;
            }
        }

        return null;
    }


    /**
     * @param $categoryData
     * @param int $parentId
     * @return Category
     */
    public function store($categoryData, $parentId = 0)
    {
        $category = new Category([
            'attribute_set_id' => 3,
            'parent_id' => $parentId,
            'path' => '',
            'position' => 1,
            'children_count' => 0
        ]);
        $category->save();
        $category->path = $this->path($parentId) .'/'. $category->entity_id;
        $category->level = $this->level($category->path);
        $category->save();

        $this->saveAttributes($categoryData, $category);

        return $category;
    }

    /**
     * @param $categoryData
     * @param $category
     */
    public function saveAttributes($categoryData, $category)
    {
        //set store id to default store
        if (!isset($categoryData['store_id'])) {
            /*
             * Here we need the AdminStoreId and not the DefaultStoreId because we never save Information to the
             * default store-view. Instead we access the admin e.g. parent information.
             */
            $categoryData['store_id'] = $this->storeRepository->getAdminStoreId();
        }
        $this->categoryAttributeRepository->save($categoryData, $category);
    }

    /**
     * @param $categoryId
     * @return mixed
     */
    public function path($categoryId)
    {
        if ($categoryId == 0) {
            $categoryId = 1;
        }

        $category = Category::whereEntityId($categoryId)->firstOrFail();
        return $category->path;
    }

    /**
     * @param $path
     * @return int
     */
    public function level($path)
    {
        $categories = collect(explode("/", $path));
        return $categories->count() - 1;
    }

    /**
     * Get info about category by category id
     * @param $categoryId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|Category
     */
    public function get($categoryId)
    {
        return Category::whereEntityId($categoryId)->firstOrFail();
    }

    /**
     * Delete category by identifier
     */
    public function delete()
    {
        // TODO: Implement delete() method.
    }
}