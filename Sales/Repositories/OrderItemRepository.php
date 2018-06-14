<?php

namespace Laragento\Sales\Repositories;

use Laragento\Sales\Models\Order;
use Laragento\Sales\Models\Order\Item;

class OrderItemRepository
{
    public function getAllItemsByOrderId($orderId)
    {
        return Item::whereOrderId($orderId)
            ->get();
    }

    public function getOrderItem($itemId)
    {
        return Item::whereItemId($itemId)
            ->first();
    }

    public function storeOrderItem($itemData)
    {
       return Item::create($itemData);
    }
}