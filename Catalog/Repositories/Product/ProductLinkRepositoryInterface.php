<?php


namespace Laragento\Catalog\Repositories\Product;


interface ProductLinkRepositoryInterface
{
    //ToDo: Not used at the moment, but perhaps we do need them some time
    const DEFAULT_PRODUCTLINK_ATTRIBUTE_TYPES = [
        'varchar',
        'decimal',
        'int'
    ];

    const CATALOG_PRODUCT_LINK_TYPES = [
        'relation' => 1,
        'super' => 3,
        'up_sell' => 4,
        'cross_sell' => 5
    ];

    public function find($productId, $linkedProductId);

    public function store($productId, $linkedProductId, $linkTypeId, $value = null);

    public function findAttributeByType($typeId);

    public function findAttributeByTypeAndCode($typeId, $attributeCode);
}