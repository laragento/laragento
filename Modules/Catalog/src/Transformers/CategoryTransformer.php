<?php

namespace Laragento\Catalog\Transformers;

use Laragento\Catalog\Models\Category\Category;
use League\Fractal;

class CategoryTransformer extends Fractal\TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var array
     */
    protected $availableIncludes = [
        'products',
        'children',
        'parent'
    ];

    protected $params = [];

    public function __construct($params = [])
    {
        $this->params = $params;
    }

    /**
     * @param Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        $entities = $category
            ->entities
            ->mapWithKeys(function ($item) {
                return [$item->attribute->attribute_code => $item['value']];
            });

        return [
            'id' => $category->entity_id,
            'category_id' => $category->entity_id,
            'name' => $entities['name'],
            'parent_id' => $category->parent_id,
            'url_path' => $this->data($entities, 'url_path'),
        ];
    }

    public function includeProducts(Category $category)
    {
        return $this->collection($category->products, new ChildProductTransformer($this->params));
    }

    public function includeChildren(Category $category)
    {
        return $this->collection($category->children, new ChildCategoryTransformer());
    }

    public function includeParent(Category $category)
    {
        return $this->item($category->parent, new ChildCategoryTransformer());
    }

    public function data($attribute, $key)
    {
        if (!isset($attribute[$key])) {
            return null;
        }
        return $attribute[$key];
    }
}