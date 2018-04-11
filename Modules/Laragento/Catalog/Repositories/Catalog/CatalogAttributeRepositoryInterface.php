<?php

namespace Laragento\Catalog\Repositories\Catalog;

interface CatalogAttributeRepositoryInterface
{
    /**
     * @param $attributeSetId
     * @return mixed
     */
    public function catalogAttributesByAttributeSet($attributeSetId);
}