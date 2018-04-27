<?php

namespace Laragento\Catalog\Repositories\Product;

interface ProductRepositoryInterface
{
    const VISIBILITY_NOT_VISIBLE_INDIVIDUALLY = 1;
    const VISIBILITY_CATALOG = 2;
    const VISIBILITY_SEARCH = 3;
    const VISIBILITY_CATALOG_SEARCH = 4;

    public function all();

    public function find($id);

    public function store($productData);

    public static function first($identifier);

    public static function product($id);

    public static function productBySku($sku);

    public static function stockByProductId($productId, $stockId = 1);
}