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

        // Get a quote and store Items
        $quote = $this->quote();
        $this->populateCart(['sku' => '003222', 'qty' => 10]);
        $this->populateCart(['sku' => '003224', 'qty' => 5]);

        // Save Order
        $order = $this->orderManager->saveOrderFromQuote($quote);


        // Confirm Entry in DB
        $this->assertDatabaseHas('sales_order', ['entity_id' => $order->entity_id]);
        $this->assertDatabaseHas('sales_order_item', ['sku' => '003222']);
        $this->assertDatabaseHas('sales_order_address', ['parent_id' => $order->entity_id]);

    }

}
