<?php

namespace Laragento\Catalog\Transformers;

use Laragento\Catalog\Models\Category\Category;
use League\Fractal;

class ChildCategoryTransformer extends Fractal\TransformerAbstract
{
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
            'url_path' => $this->data($entities, 'url_path'),
        ];
    }

    public function data($attribute, $key)
    {
        if (!isset($attribute[$key])) {
            return null;
        }
        return $attribute[$key];
    }
}