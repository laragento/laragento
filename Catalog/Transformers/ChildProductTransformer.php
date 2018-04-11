<?php

namespace Laragento\Catalog\Transformers;

use Laragento\Catalog\Models\Product\Product;
use League\Fractal;

class ChildProductTransformer extends Fractal\TransformerAbstract
{
    protected $params = [];

    public function __construct($params = [])
    {
        $this->params = $params;
    }

    /**
     * @param Product $product
     * @return array
     */
    public function transform(Product $product)
    {
        $attributes = $product
            ->entities($this->getStoreId())->get()
            ->mapWithKeys(function ($item) {
                if ($item['store_id'] == $this->getStoreId() && $item['store_id'] !== 0) {
                    return [$item->attribute->attribute_code . '-store-' . $item['store_id']  => $item['value']];
                }
                if ($item['store_id'] === 0) {
                    return [$item->attribute->attribute_code => $item['value']];
                }
                return [];

            });

        return [
            'id' => $product->entity_id,
            'entities' => $attributes,
            'store_id' => $this->getStoreId(),
            'url_key' => $this->data($attributes, 'url_key'),
            'sku' => $product->sku,
            'name' => $this->data($attributes, 'name'),
            'price' => $this->price($attributes, 'price'),
            'small_image' => $this->data($attributes, 'small_image'),
            'small_image_label' => $this->data($attributes, 'small_image_label'),
            'short_description' => $this->data($attributes, 'short_description'),
            'description' => $this->data($attributes, 'description'),
        ];
    }

    public function price($attributes, $key)
    {
        $storeKey = $key . '-store-' . $this->getStoreId();
        if (!isset($attributes[$key]) && !isset($attributes[$storeKey])) {
            return 0.00;
        }
        return isset($attributes[$storeKey]) ? $attributes[$storeKey] : $attributes[$key];
    }

    public function data($attributes, $key)
    {
        $storeKey = $key . '-store-' . $this->getStoreId();
        if (!isset($attributes[$key]) && !isset($attributes[$storeKey])) {
            return null;
        }
        return isset($attributes[$storeKey]) ? $attributes[$storeKey] : $attributes[$key];

    }

    protected function getStoreId()
    {
        return isset($this->params['store_id']) ? $this->params['store_id'] : 0;
    }
}