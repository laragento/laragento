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

    public function find($productId, $linkedProductId);

    public function store($productId, $linkedProductId, $linkTypeId, $value = null);

    public function findAttributeByType($typeId);

    public function findAttributeByTypeAndCode($typeId, $attributeCode);
}