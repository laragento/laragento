<?php

namespace Laragento\Catalog\Repositories\Product;

interface ProductAttributeRepositoryInterface
{
    public function save($productData, $productId);

    public function data($attributeCode, $productId);

    public function saveEntity($attribute, $entity);
}