<?php

namespace Laragento\Indexer\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use DateTime;

class IndexerCommand extends Command
{
    protected $countUpdates;
    protected $indexTableModified;

    /**
     * Fill index table with defined cols
     *
     * @param $indexTable
     * @param $attributes
     */
    protected function syncIndexerCols($indexTable, $attributes) {
        foreach($attributes as $attribute => $type) {
            if(!Schema::hasColumn($indexTable, $attribute)) {
                //create collumn if not found in table
                Schema::table($indexTable, function($table) use($attribute, $type) {
                    switch($type) {
                        case 'text':
                            $table->text($attribute)->nullable();
                            break;
                        case 'float':
                            $table->float($attribute)->default(0)->nullable();
                            break;
                        default:
                            $table->string($attribute, 255)->default('')->nullable();
                    }
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
     */
    protected function updateIndexerTable($table, $cacheKey, $attributes, $storeIds, $foreignKey, $indexClass, $attributeRepository) {
        //if index table is modified, reset last execution timestamp
        if($this->indexTableModified) {
            Cache::forget($cacheKey);
        }

        //check last execution time
        $lastExecutionTimestamp = Cache::get($cacheKey);

        $lastExecution = null;
        $query = DB::table($table);

        if($lastExecutionTimestamp != null) {
            $lastExecution = new DateTime();
            $lastExecution->setTimestamp($lastExecutionTimestamp);
            $query = $query->where('updated_at', '>', $lastExecution->format('Y-m-d H:i:s'));
        }

        $this->countUpdates = 0;

        $query->orderBy('entity_id')->chunk(100, function ($items) use($attributes, $storeIds, $foreignKey, $indexClass, $attributeRepository) {
            foreach($items as $item) {
                $this->countUpdates++;

                //update attributes in index table for stores
                foreach($storeIds as $storeId) {
                    $productIndex = $indexClass::firstOrNew([
                        $foreignKey => $item->entity_id,
                        'store_id' => $storeId
                    ]);

                    foreach($attributes as $attribute => $type) {
                        $data = $attributeRepository->data($attribute, $item->entity_id, $storeId);
                        //if data not found for specific storeId, search in default store 0
                        if(!$data) {
                            $data = $attributeRepository->data($attribute, $item->entity_id);
                        }

                        $productIndex->{$attribute} = $data ? $data->value : '';
                    }

                    $productIndex->save();
                }
            }
        });

        //update last execution timestamp
        $timestamp = time();
        print 'Items updated: ' . $this->countUpdates . "\n";
        print 'Cache timestamp: ' . $timestamp . "\n";
        Cache::forever($cacheKey, $timestamp);
    }
}