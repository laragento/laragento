<?php

namespace Laragento\Indexer\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laragento\Catalog\Repositories\Product\ProductAttributeRepositoryInterface;
use Laragento\Indexer\Models\ProductIndex;

use Validator;
use DateTime;

class IndexerUpdateProducts extends IndexerCommand
{
    protected $productAttributeRepository;
    protected $countUpdates;

    public function __construct(
        ProductAttributeRepositoryInterface $productAttributeRepository
    ) {
        $this->productAttributeRepository = $productAttributeRepository;

        parent::__construct();
    }

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'indexer:update-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update products in index table.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //check if attributes present in indexer table
        $productAttributes = Config::get('indexer.product_attributes');
        $storeIds = Config::get('indexer.stores');

        $this->syncIndexerCols('lg_catalog_product_index', $productAttributes);

        $this->updateIndexerTable('lg_catalog_product_index', 'indexer-update-products-timestamp', $productAttributes, $storeIds, 'product_id', ProductIndex::class, $this->productAttributeRepository);
    }
}
