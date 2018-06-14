<?php

namespace Laragento\Indexer\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laragento\Catalog\Repositories\Category\CategoryAttributeRepositoryInterface;
use Laragento\Indexer\Models\CategoryIndex;
use Modules\BachmannkartenShop\Models\Customer;
use Modules\BachmannkartenNavision\OData\Navision;

use Validator;
use DateTime;

class IndexerUpdateCategories extends Command
{
    protected $categoryAttributeRepository;
    protected $countUpdates;

    public function __construct(
        CategoryAttributeRepositoryInterface $categoryAttributeRepository
    ) {
        $this->categoryAttributeRepository = $categoryAttributeRepository;

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

        foreach($categoryAttributes as $categoryAttribute) {
            if(!Schema::hasColumn('lg_catalog_category_index', $categoryAttribute)) {
                //create collumn if not found in table
                Schema::table('lg_catalog_category_index', function($table) use($categoryAttribute) {
                    $table->string($categoryAttribute, 255)->default('');
                });
            }
        }

        //check last execution time
        $lastExecutionTimestamp = Cache::get('indexer-update-categories-timestamp');

        $lastExecution = null;
        $query = DB::table('catalog_category_entity');

        if($lastExecutionTimestamp != null) {
            $lastExecution = new DateTime();
            $lastExecution->setTimestamp($lastExecutionTimestamp);
            $query = $query->where('updated_at', '>', $lastExecution->format('Y-m-d H:i:s'));
        }

        $this->countUpdates = 0;

        $query->orderBy('entity_id')->chunk(100, function ($categories) use($categoryAttributes, $storeIds) {
            foreach($categories as $category) {
                $this->countUpdates++;

                //update attributes in index table for stores
                foreach($storeIds as $storeId) {
                    $categoryIndex = CategoryIndex::firstOrNew([
                        'category_id' => $category->entity_id,
                        'store_id' => $storeId
                    ]);

                    foreach($categoryAttributes as $categoryAttribute) {
                        $data = $this->categoryAttributeRepository->data($categoryAttribute, $category->entity_id, $storeId);
                        //if data not found for specific storeId, search in default store 0
                        if(!$data) {
                            $data = $this->categoryAttributeRepository->data($categoryAttribute, $category->entity_id);
                        }

                        $categoryIndex->{$categoryAttribute} = $data ? $data->value : '';
                    }

                    $categoryIndex->save();
                }
            }
        });

        //update last execution timestamp
        $timestamp = time();
        print 'Categories updated: ' . $this->countUpdates . "\n";
        print 'Cache timestamp: ' . $timestamp . "\n";
        Cache::forever('indexer-update-categories-timestamp', $timestamp);
    }
}
