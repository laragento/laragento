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

    public function __construct(
        ProductAttributeRepositoryInterface $productAttributeRepository
    ) {
        $this->productAttributeRepository = $productAttributeRepository;
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
        foreach($productAttributes as $productAttribute) {
            if(!Schema::hasColumn('catalog_product_entity', $productAttribute)) {
                //create collumn if not found in table
                Schema::table('catalog_product_entity', function($table) use($productAttribute) {
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

        $query->orderBy('entity_id')->chunk(100, function ($products) use($productAttributes) {
            foreach($products as $product) {
                //update attributes in index table
                $productIndex = ProductIndex::firstOrNew(['product_id' => $product->entity_id]);

                foreach($productAttributes as $productAttribute) {
                    $productIndex->{$productAttribute} =  ($data = $this->productAttributeRepository->data($productAttribute, $product->entity_id)) ? $data->value : '';
                }

                $productIndex->save();
            }
        });

        //update last execution timestamp
        $timestamp = time();
        print 'Cache timestamp: ' . $timestamp . "\n";
        Cache::forever('indexer-update-products-timestamp', $timestamp);
    }
}
