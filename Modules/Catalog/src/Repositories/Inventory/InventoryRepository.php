<?php


namespace Laragento\Catalog\Repositories\Inventory;

use Laragento\Catalog\Models\Inventory\StockItem;
use Laragento\Catalog\Models\Inventory\StockStatus;


/**
 * Class InventoryRepository
 * @package Laragento\Catalog\Repositories\Inventory
 */
class InventoryRepository implements InventoryRepositoryInterface
{

    protected $stockItem;
    protected $stockStatus;

    public function store($product)
    {
        $this->createStockRelationData($product);
        $this->storeStockItem($this->stockItem);
        $this->storeStockStatus($this->stockStatus);
    }

    /*
     * @todo Website_Id is hardcoded
     * @todo Stock_Id is hardcoded
     * @todo max_sale_qty is hardcoded
     */
    private function createStockRelationData($product)
    {
        $stockStatusValue = $product['qty'] > 0 ? 1 : 0;

        $data = [
            'product_id' => $product['entity_id'],
            'website_id' => 0,
            'stock_id' => 1,
            'qty' => $product['qty'],
            'stock_status' => $stockStatusValue,
        ];

        $this->stockItem = $this->stockStatus = $data;

        $this->stockItem['max_sale_qty'] = 10000;
        $this->stockStatus['stock_status'] = $stockStatusValue;

    }

    /**
     * @param $stockItemData
     * @return StockItem
     */
    private function storeStockItem($stockItemData)
    {
        $stockItem = StockItem::where(['product_id' => $stockItemData['product_id']])->first();

        if (!$stockItem) {
            $stockItem = new StockItem($stockItemData);
            $stockItem->save();
        } else {
            $stockItem->update($stockItemData);
        }
        return $stockItem;
    }

    private function storeStockStatus($stockStatusData)
    {
        $stockStatus = StockStatus::where(['product_id' => $stockStatusData['product_id']])->first();

        if (!$stockStatus) {
            $stockStatus = new StockStatus($stockStatusData);
            $stockStatus->save();

            //printf("\n\rCreating new StockStatus");
        } else {
            $stockStatus->update($stockStatusData);

            //printf("\n\rUpdating the StockStatus");

        }

        return $stockStatus;
    }
}