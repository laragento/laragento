<?php


namespace Laragento\Sales\Managers;

use Laragento\Quote\DataObject\QuoteSessionObject;
use Laragento\Store\Models\Store;

class OrderManager
{
    public function quoteToOrder(QuoteSessionObject $quote)
    {
        $store = Store::whereStoreId($quote->getStoreId())->first();
        return [
            "state" => "new",
            "status" => "pending",
            "coupon_code" => $quote->getCouponCode(),
            "protect_code" => substr(md5(uniqid(mt_rand(), true) . ':' . microtime(true)), 5, 6),
            "shipping_description" => "versandkostenfrei", // ToDo Get from Shippipng Entity
            "is_virtual" => 0,
            "store_id" => $store->store_id,
            "customer_id" => $quote->getCustomerId(),
            "base_discount_amount" => $quote->getBaseSubtotal() - $quote->getBaseSubtotalWithDiscount(),
            "base_grand_total" => $quote->getBaseGrandTotal(),
            "base_subtotal" => $quote->getBaseSubtotal(),
            "base_tax_amount" => "", //ToDo calculate
            "shipping_amount" => "0.0000", // ToDo Get from Shippipng Entity
            "total_qty_ordered" => $quote->getItemsQty(),
            "customer_is_guest" => 0,
            "billing_address_id" => $quote->customer()->billing['entity_id'],
            "customer_group_id" => $quote->customer()->group['customer_group_id'],
            "email_sent" => 0,
            "send_email" => 1,
            "shipping_address_id" => $quote->customer()->shipping['entity_id'],
            "subtotal_incl_tax" => $quote->getSubtotal(), // ToDo Tax Calculation
            "increment_id" => "",
            "base_currency_code" => $quote->getBaseCurrencyCode(),
            "customer_email" => $quote->customer()->email,
            "customer_firstname" => $quote->customer()->firstname,
            "customer_lastname" => $quote->customer()->lastname,
            "customer_middlename" => $quote->customer()->middlename,
            "customer_prefix" => $quote->customer()->prefix,
            "customer_suffix" => $quote->customer()->suffix,
            "customer_taxvat" => $quote->customer()->taxvat,
            "discount_description" => "", // ToDo make dynamic
            "order_currency_code" => $quote->getQuoteCurrencyCode(),
            "original_increment_id" => "",
            "shipping_method" => "versandkostenfrei", // ToDo make dynamic
            "store_name" => $store->name,
            "customer_note" => "" // ToDo make dynamic
        ];
    }
}