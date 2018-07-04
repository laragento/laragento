<?php

namespace Laragento\Indexer\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use DateTime;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;

class IndexerCommand extends Command
{
    protected $indexTableModified;
    protected $updatedIndexes;

    /**
     * Fill index table with defined cols
     *
     * @param $indexTable
     * @param $attributes
     * @param array $ignoreCols
     */
    protected function syncIndexerCols($indexTable, $attributes, $ignoreCols = []) {
        foreach($attributes as $attribute => $config) {
            if(!Schema::hasColumn($indexTable, $attribute)) {
                //create collumn if not found in table
                Schema::table($indexTable, function($table) use($attribute, $config) {
                    switch($config['type']) {
                        case 'text':
                            $table->text($attribute)->nullable();
                            break;
                        case 'float':
                            $table->float($attribute)->default(0)->nullable();
                            break;
                        case 'boolean':
                            $table->boolean($attribute)->nullable();
                            break;
                        case 'integer':
                            $table->integer($attribute)->default(0)->nullable();
                            break;
                        case 'string':
                            $table->string($attribute, 255)->default('')->nullable();
                            break;
                        default:
                            die('attribute type: ' . $config['type'] . ' not implemented');
                    }
                });

                $this->indexTableModified = true;
            }
        }

        //remove unused cols
        $tableCols = Schema::getColumnListing($indexTable);
        foreach($tableCols as $tableCol) {
            //ignore specific cols
            if(in_array($tableCol, $ignoreCols)) {
                continue;
            }

            //remove col if not in attributes any more
            if(!in_array($tableCol, array_keys($attributes))) {
                Schema::table($indexTable, function($table) use($tableCol) {
                    $table->dropColumn($tableCol);
                });

                $this->indexTableModified = true;
            }
        }
    }

    /**
     * Update indexer Table with defined attributes in config
     *
     * @param $table
     * @param $cacheKey
     * @param $attributes
     * @param $storeIds
     * @param $foreignKey
     * @param $indexClass
     * @param $attributeRepository
     * @param $productRepository
     * @param $filter
     * @return array
     */
    protected function updateIndexerTable($table, $cacheKey, $attributes, $storeIds, $foreignKey, $indexClass, $attributeRepository, $productRepository, $filter) {
        //if index table is modified, reset last execution timestamp
        if($this->indexTableModified) {
            Cache::forget($cacheKey);
        }

        //check last execution time
        $timestamp = time();
        $lastExecutionTimestamp = Cache::get($cacheKey);

        $lastExecution = null;
        $query = DB::table($table);

        if($lastExecutionTimestamp != null) {
            $lastExecution = new DateTime();
            $lastExecution->setTimestamp($lastExecutionTimestamp);
            $query = $query->where('updated_at', '>', $lastExecution->format('Y-m-d H:i:s'));
        }

        $this->updatedIndexes = [];

        $query->orderBy('entity_id')->chunk(100, function ($items) use($attributes, $storeIds, $foreignKey, $indexClass, $attributeRepository, $productRepository, $filter) {
            foreach($items as $item) {
                //update attributes in index table for stores
                foreach($storeIds as $storeId) {
                    $indexModel = $indexClass::firstOrNew([
                        $foreignKey => $item->entity_id,
                        'store_id' => $storeId
                    ]);

                    //TODO check if product / category active for current StoreID
                    if(isset($filter) && $filter != '') {
                        //if filter return false abort processing entry
                        if(!$this->executeCode($filter, 'execute', [$item->entity_id, $productRepository, $attributeRepository, $indexModel])) {
                            $indexClass::where($foreignKey, '=', $item->entity_id)->where('store_id', '=', $storeId)->delete();
                        }
                    }

                    foreach($attributes as $attribute => $config) {
                        $value = '';

                        if(isset($config['handler'])) {
                            $value = $this->executeCode($config['handler'], 'execute', [$item->entity_id, $productRepository, $attribute, $attributeRepository, $indexModel]);
                        } else {
                            $data = $attributeRepository->data($attribute, $item->entity_id, $storeId);
                            //if data not found for specific storeId, search in default store 0
                            if(!$data) {
                                $data = $attributeRepository->data($attribute, $item->entity_id);
                            }

                            if($data) {
                                $value = $data->value;
                            }
                        }

                        //handle boolean types
                        if($config['type'] == 'boolean') {
                            $indexModel->{$attribute} = $value ? true : false;
                        } else {
                            $indexModel->{$attribute} = $value;
                        }
                    }

                    $indexModel->save();

                    $this->updatedIndexes[] = $indexModel;
                }
            }
        });

        //update last execution timestamp
        print 'Items updated: ' . count($this->updatedIndexes) . "\n";
        print 'Cache timestamp: ' . $timestamp . "\n";
        Cache::forever($cacheKey, $timestamp);

        return $this->updatedIndexes;
    }

    /**
     * @param $class
     * @param $function
     * @param $params
     * @return bool|mixed
     */
    private function executeCode($class, $function, $params) {
        if(!method_exists($class, $function)) {
            return false;
        }
        if(!is_callable([$class, $function])) {
            return false;
        }

        return call_user_func_array([$class, $function], $params);
    }
}