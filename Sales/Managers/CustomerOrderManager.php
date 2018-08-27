<?php


namespace Laragento\Sales\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Store\Models\Store;

class CustomerOrderManager extends AbstractOrderManager
{
    /**
     * @param QuoteSessionObject $quote
     * @return array
     */
    protected function mapQuoteToOrder($quote)
    {
        $store = Store::whereStoreId($quote->getStoreId())->first();
        $customer = $quote->customer();
        $customAttributes = $quote->getCustomAttributes();
        if (isset($customAttributes['totals'])) {
            $baseTaxAmount = $customAttributes['totals']->getTaxAmount(); //ToDo calculate
            $taxAmount = $customAttributes['totals']->getTaxAmount(); //ToDo calculate
        } else {
            $baseTaxAmount = 0.00; //ToDo calculate
            $taxAmount = 0.00; //ToDo calculate
        }

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
            "base_tax_amount" => $baseTaxAmount,
            "tax_amount" => $taxAmount,
            "shipping_amount" => "0.0000", // ToDo Get from shipping entity
            "total_qty_ordered" => $quote->items_qty, // todo check
            "customer_is_guest" => 0,
            "billing_address_id" => $customer->billing['entity_id'],
            "email_sent" => 0,
            "send_email" => 1,
            "shipping_address_id" => $customer->shipping['entity_id'],
            "subtotal_incl_tax" => $quote->subtotal, // ToDo Tax Calculation
            "increment_id" => $this->incrementId(),
            "base_currency_code" => $quote->base_currency_code,
            "store_currency_code" => $quote->store_currency_code,
            "order_currency_code" => $quote->quote_currency_code,
            "discount_description" => "", // ToDo make dynamic
            "original_increment_id" => "",
            "shipping_method" => $quote->shipping->method,
            "store_name" => $store->name,
            "customer_note" => "", // ToDo make dynamic
            "customer_group_id" => $customer->group['customer_group_id'],
            "customer_id" => $quote->customer_id,
            "customer_email" => $customer->email,
            "customer_firstname" => $customer->firstname,
            "customer_lastname" => $customer->lastname,
            "customer_middlename" => $customer->middlename,
            "customer_prefix" => $customer->prefix,
            "customer_suffix" => $customer->suffix,
            "customer_taxvat" => $customer->taxvat,
        ];
    }
}