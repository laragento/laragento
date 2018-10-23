<?php

namespace Laragento\CatalogImportExport\Repositories;

interface ProductImportRepositoryInterface
{

    const LINK_TYPE_ID = 3;

    public function import($productData, $config = false);
}