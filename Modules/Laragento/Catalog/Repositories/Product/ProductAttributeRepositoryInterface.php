<?php

namespace Laragento\Catalog\Repositories\Product;

interface ProductAttributeRepositoryInterface
{
    public function save($productData, $productId, $update);

    public function data($attributeCode, $product_id);

    public function saveEntity($attribute, $entity);
}