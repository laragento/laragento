<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laragento\Sales\Models\Order;
use Laragento\Sales\Models\Order\Item;
use Laragento\Sales\Tests\SalesTestCase;

class StoreOrderTest extends SalesTestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function storeOrder()
    {

        // Get a quote
        $quote = $this->quote();
        $items = $quote->getItems();
        // Save Order
        $orderData = $this->orderManager->quoteToOrder($quote);

        $order = Order::create($orderData);
        foreach ($items as $item) {
            $itemData = $this->orderManager->quoteItemToOrderItem($item, $order);
            $orderItem = Item::create($itemData);
            $this->assertDatabaseHas('sales_order_item', ['item_id' => $orderItem->item_id]);
        }

        // Confirm Entry in DB
        $this->assertDatabaseHas('sales_order', ['entity_id' => $order->entity_id]);

    }

}
