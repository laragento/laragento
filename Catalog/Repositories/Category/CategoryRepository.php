<?php

namespace Laragento\Catalog\Repositories\Category;

use Laragento\Catalog\Models\Category\Category;
use Laragento\Catalog\Models\Category\Entity\Integer;
use Laragento\Catalog\Models\Category\Entity\Varchar;


class CategoryRepository implements CategoryRepositoryInterface
{
    protected $errors;

    /**
     * @return mixed
     */
    public function all()
    {
        return Category::with('children.entities', 'entities')->get();
    }

    /**
     * @return mixed
     */
    public function allByLevel()
    {
        return Category::with('children.entities', 'entities')
            ->whereLevel(0)->get();
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
     * @return null
     */
    public static function getCategoryIdByName($categoryName, $storeId = 0)
    {
        $entity = Varchar::whereValue($categoryName)
            ->whereStoreId($storeId)
            ->whereAttributeId(45)
            ->first();
        if (!$entity) {
            return null;
        }
        return $entity->entity_id;
    }


    /**
     * @param $categoryData
     * @param int $parentId
     * @return Category
     */
    public function store($categoryData, $parentId = 0, $storeId)
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

        //category name attribute
        $entity = new Varchar([
            'attribute_id' => 45,
            'store_id' => $storeId,
            'entity_id' => $category->entity_id,
            'value' => $categoryData['name']
        ]);
        $entity->save();

        //category is_active attribute
        $entity = new Integer([
            'attribute_id' => 46,
            'store_id' => $storeId,
            'entity_id' => $category->entity_id,
            'value' => 1
        ]);
        $entity->save();

        //category is_anchor attribute
        $entity = new Integer([
            'attribute_id' => 54,
            'store_id' => $storeId,
            'entity_id' => $category->entity_id,
            'value' => 1
        ]);
        $entity->save();

        //category include in menu attribute
        $entity = new Integer([
            'attribute_id' => 69,
            'store_id' => $storeId,
            'entity_id' => $category->entity_id,
            'value' => 1
        ]);
        $entity->save();

        return $category;
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
        $category = Category::whereEntityId($categoryId)->first();
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
     */
    public function get($categoryId, $storeId = null)
    {
        // TODO: Implement get() method.
    }

    /**
     * Delete category by identifier
     */
    public function delete()
    {
        // TODO: Implement delete() method.
    }
}