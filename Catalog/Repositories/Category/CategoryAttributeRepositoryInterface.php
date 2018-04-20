<?php

namespace Laragento\Catalog\Repositories\Category;

interface CategoryAttributeRepositoryInterface
{
    public function save($categoryData, $categoryId);

    public function data($attributeCode, $categoryId);

    public function saveEntity($attribute, $entity);
}