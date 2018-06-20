<?php

namespace Laragento\Indexer\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laragento\Catalog\Repositories\Category\CategoryAttributeRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;
use Laragento\Indexer\Events\CategoriesIndexed;
use Laragento\Indexer\Models\CategoryIndex;
use Modules\BachmannkartenShop\Models\Customer;
use Modules\BachmannkartenNavision\OData\Navision;

use Validator;
use DateTime;

class IndexerUpdateCategories extends IndexerCommand
{
    protected $categoryAttributeRepository;
    protected $productRepository;

    protected $countUpdates;

    public function __construct(
        CategoryAttributeRepositoryInterface $categoryAttributeRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->categoryAttributeRepository = $categoryAttributeRepository;
        $this->productRepository = $productRepository;

        parent::__construct();
    }

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'indexer:update-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update categories in index table.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //check if attributes present in indexer table
        $categoryAttributes = Config::get('indexer.category_attributes');
        $storeIds = Config::get('indexer.stores');

        $this->syncIndexerCols('lg_catalog_category_index', $categoryAttributes);

        $updatedIndexes = $this->updateIndexerTable('catalog_category_entity', 'indexer-update-categories-timestamp', $categoryAttributes, $storeIds, 'category_id', CategoryIndex::class, $this->categoryAttributeRepository, $this->productRepository);

        event(new CategoriesIndexed($updatedIndexes));
    }
}
