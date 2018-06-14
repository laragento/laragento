<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laragento\Sales\Models\Order;
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

        // Save Order
        $orderData = $this->orderManager->quoteToOrder($quote);
        $order = Order::create($orderData);

        // Confirm Entry in DB
        $this->assertDatabaseHas('sales_order', ['entity_id' => $order->entity_id]);
    }

}
