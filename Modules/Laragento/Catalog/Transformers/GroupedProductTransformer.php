<?php

namespace Laragento\Catalog\Transformers;

use Laragento\Catalog\Models\Product\Product;
use Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepository;
use League\Fractal;

class GroupedProductTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = [
        'categories',
        'children'
        //'group'
    ];

    /**
     * @param Product $product
     * @return array
     */
    public function transform(Product $product)
    {
//            $links = $product
//                  ->links
//                  ->map(function ($linkProduct) {
//                        return $linkProduct
//                              ->entities
//                              ->mapWithKeys(function ($item) {
//                                    return [$item->attribute->attribute_code => $item['value']];
//                              });
//                  });

        $attributes = $product
            ->entities
            ->mapWithKeys(function ($item) {
                return [$item->attribute->attribute_code => $item['value']];
            });

        return array_merge([
            'id' => $product['entity_id'],
            'sku' => $product['sku'],
            'name' => $attributes['name'],
            'meta_title' => $this->data($attributes, 'meta_title'),
            'image' => $this->data($attributes, 'image'),
            'small_image' => $this->data($attributes, 'small_image'),
            'thumbnail' => $this->data($attributes, 'thumbnail'),
            'options_container' => $attributes['options_container'],
            'image_label' => $this->data($attributes, 'image_label'),
            'url_key' => $attributes['url_key'],
            'tax_class_id' => $this->data($attributes, 'tax_class_id'),
            'short_description' => $this->data($attributes, 'short_description'),
        ], $this->additionalAttributes($attributes));
    }

    public function includeCategories(Product $product)
    {
        return $this->collection($product->categories, new ProductCategoryTransformer());
    }

    public function includeChildren(Product $product)
    {
        return $this->collection($product->children, new ChildProductTransformer());
    }

    public function data($attribute, $key)
    {
        if (!isset($attribute[$key])) {
            return null;
        }
        return $attribute[$key];
    }

    public function additionalAttributes($productAttributes)
    {
        $catalogAttributeRepository = new CatalogAttributeRepository();
        $attributes = $catalogAttributeRepository->catalogAttributesByAttributeSet(4);
        $data = [];
        foreach ($attributes as $attribute) {
            if (isset($productAttributes[$attribute->attribute_code])) {
                $data[$attribute->attribute_code] = $productAttributes[$attribute->attribute_code];
            }
        }
        return $data;
    }
}