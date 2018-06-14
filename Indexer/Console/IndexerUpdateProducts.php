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

class IndexerUpdateProducts extends Command
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

        foreach($productAttributes as $productAttribute) {
            if(!Schema::hasColumn('lg_catalog_product_index', $productAttribute)) {
                //create collumn if not found in table
                Schema::table('lg_catalog_product_index', function($table) use($productAttribute) {
                    $table->string($productAttribute, 255)->default('');
                });
            }
        }

        //check last execution time
        $lastExecutionTimestamp = Cache::get('indexer-update-products-timestamp');

        $lastExecution = null;
        $query = DB::table('catalog_product_entity');

        if($lastExecutionTimestamp != null) {
            $lastExecution = new DateTime();
            $lastExecution->setTimestamp($lastExecutionTimestamp);
            $query = $query->where('updated_at', '>', $lastExecution->format('Y-m-d H:i:s'));
        }

        $this->countUpdates = 0;

        $query->orderBy('entity_id')->chunk(100, function ($products) use($productAttributes, $storeIds) {
            foreach($products as $product) {
                $this->countUpdates++;

                //update attributes in index table for stores
                foreach($storeIds as $storeId) {
                    $productIndex = ProductIndex::firstOrNew([
                        'product_id' => $product->entity_id,
                        'store_id' => $storeId
                    ]);

                    foreach($productAttributes as $productAttribute) {
                        $data = $this->productAttributeRepository->data($productAttribute, $product->entity_id, $storeId);
                        //if data not found for specific storeId, search in default store 0
                        if(!$data) {
                            $data = $this->productAttributeRepository->data($productAttribute, $product->entity_id);
                        }

                        $productIndex->{$productAttribute} = $data ? $data->value : '';
                    }

                    $productIndex->save();
                }
            }
        });

        //update last execution timestamp
        $timestamp = time();
        print 'Products updated: ' . $this->countUpdates . "\n";
        print 'Cache timestamp: ' . $timestamp . "\n";
        Cache::forever('indexer-update-products-timestamp', $timestamp);
    }
}
