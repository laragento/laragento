<?php

namespace Laragento\Sales\Providers;

use Modules\Sales\Models\Order;

class SalesRepository
{
    public function getNewestOrdersByCustomer($customerId)
    {
        return Order::orderby('entity_id', 'DESC')
            ->where('customer_id', $customerId)
            ->limit(10)
            ->get();
    }

    public function getOrder($orderId, $customerId)
    {
        return Order::orderby('entity_id', 'DESC')
            ->where('entity_id', $orderId)
            ->where('customer_id', $customerId)
            ->first();
    }

    public function getOrdersFromTo()
    {
        return Order::with(['items', 'addresses'])
            ->orderby('entity_id', 'DESC')
            ->where('status', 'pending')
            ->limit(100)
            ->get();
    }

    public function store()
    {

    }
}