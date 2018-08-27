<?php

namespace Laragento\Sales\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Store\Models\Store;

class GuestOrderManager extends AbstractOrderManager
{
    /**
     * @param QuoteSessionObject $quote
     * @return array
     */
    protected function mapQuoteToOrder($quote)
    {
        $store = Store::whereStoreId($quote->getStoreId())->first();
        return [
            "state" => self::ORDER_STATE_NEW,
            "status" => self::ORDER_STATUS_PENDING,
            "coupon_code" => $quote->getCouponCode(),
            "protect_code" => $this->protectCode(),
            "shipping_description" => $quote->shipping->description,
            "is_virtual" => 0,
            "store_id" => $store->store_id,
            "base_discount_amount" => $quote->base_subtotal - $quote->base_subtotal_with_discount,
            "discount_amount" => $quote->subtotal - $quote->subtotal_with_discount,
            "base_grand_total" => $quote->base_grand_total,
            "grand_total" => $quote->grand_total,
            "base_subtotal" => $quote->base_subtotal,
            "subtotal" => $quote->subtotal,
            "base_tax_amount" => "0.0000", // ToDo Tax Calculation
            "tax_amount" => "0.0000", // ToDo Tax Calculation
            "shipping_amount" => "0.0000", // ToDo Get from shipping entity
            "total_qty_ordered" => $quote->items_qty, // todo check
            "customer_is_guest" => 1,
            "billing_address_id" => null, // ToDo!!
            "email_sent" => 0,
            "send_email" => 1,
            "shipping_address_id" => null, // ToDo!!
            "subtotal_incl_tax" => $quote->subtotal, // ToDo Tax Calculation
            "increment_id" => $this->incrementId(),
            "base_currency_code" => $quote->base_currency_code,
            "store_currency_code" => $quote->store_currency_code,
            "order_currency_code" => $quote->quote_currency_code,
            "discount_description" => "", // ToDo make dynamic
            "original_increment_id" => "",
            "shipping_method" => $quote->shipping->method,
            "store_name" => $store->name,
            "customer_note" => "" // ToDo make dynamic
        ];
    }
}