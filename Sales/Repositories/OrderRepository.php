<?php

namespace Laragento\Sales\Repositories;

use Laragento\Sales\Models\Order;

class OrderRepository
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

    public function store($orderData)
    {
        return Order::create($orderData);
    }
}