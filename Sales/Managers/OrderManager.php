<?php


namespace Laragento\Sales\Managers;

use Laragento\Quote\DataObject\QuoteSessionItem;
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
            "base_tax_amount" => "0.0000", //ToDo calculate
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

    public function quoteItemToOrderItem(QuoteSessionItem $item, $order)
    {
        return [
            'order_id' => $order->entity_id,
            'parent_item_id' => null,
            'quote_item_id' => $item->getItemId(),
            'store_id' => $item->getStoreId(),
            'product_id' => $item->getProductId(),
            'product_type' => $item->product()->type,
            'product_options' => $item->product()->options,
            'sku' => $item->getSku(),
            'name' => $item->getName(),
            'description' => $item->getDescription(),
            'qty_ordered' => $item->getQty(),
            'price' => $item->getPrice(),
            'base_price' => $item->getBasePrice(),
            'original_price' => $item->product()->price,
            'base_original_price' => $item->product()->price, // ToDo
            'tax_percent' => $item->getTaxPercent(),
            'tax_amount' => $item->getTaxAmount(),
            'base_tax_amount' => $item->getBaseTaxAmount(),
            'discount_percent' => $item->getDiscountPercent(),
            'discount_amount' => $item->getDiscountAmount(),
            'base_discount_amount' => $item->getBaseDiscountAmount(),
            'row_total' => $item->getRowTotal(),
            'base_row_total' => $item->getBaseRowTotal(),
            'row_weight' => $item->getRowWeight(),
            'base_tax_before_discount' => $item->getBaseTaxAmount(), // ToDo
            'tax_before_discount' => $item->getBaseTaxAmount(), // ToDo
            'ext_order_item_id' => null,
            'locked_do_invoice' => null,
            'locked_do_ship' => null,
            'price_incl_tax' => $item->getPriceInclTax(),
            'base_price_incl_tax' => $item->getBasePriceInclTax(),
            'row_total_incl_tax' => $item->getRowTotalInclTax(),
            'base_row_total_incl_tax' => $item->getBaseRowTotalInclTax(),
            'free_shipping' => $item->getFreeShipping()
        ];
    }
}