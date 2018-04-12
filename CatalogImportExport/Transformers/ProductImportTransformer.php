<?php

namespace Laragento\CatalogImportExport\Transformers;

use League\Fractal;

class ProductImportTransformer extends Fractal\TransformerAbstract
{

    /**
     * @param $product
     * @return array
     */
    public function transform($product)
    {
        return $this->getProductData($product);
    }

    /**
     * @param \stdClass $product
     * @return array
     */
    private function getProductData(\stdClass $product)
    {
        return [
            'website_id' => $this->websiteId($product->website_id),
            'attribute_set_id' => 4,
            'type_id' => 'simple',
            'sku' => $product->sku,
            'price' => $this->price($product->price),
            'qty' => $product->qty,
            'tax' => $product->tax,
            'has_options' => 0,
            'required_options' => 0,
        ];
    }

    protected function websiteId($id)
    {
        return $id ? $id : null;
    }

    protected function storeId($id)
    {
        return $id ? $id : null;
    }

    protected function urlKey($string)
    {
        return str_slug($string);
    }

    protected function weight($weight)
    {
        $formattedWeight = str_replace(',', '.', $weight);
        if (!$formattedWeight) {
            return 0.1;
        }
        return $formattedWeight;
    }

    protected function price($price)
    {
        return $this->double($price);
    }

    protected function double($string)
    {
        if (!$string) {
            return 0.0;
        }
        return str_replace(',', '.', $string);
    }

    protected function specialDate($date)
    {
        if (!$date) {
            return '2000-01-01 00:00:00';
        }
        return $date;
    }
}