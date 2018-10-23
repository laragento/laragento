<?php

namespace Laragento\CustomerImportExport\Repositories;

interface CustomerImportRepositoryInterface
{
    public function import($customerData);
}