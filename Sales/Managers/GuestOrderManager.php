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
        $fullStoreName = $store->website->name . "\n\r" . $store->group->name . "\n\r" . $store->name;
        return [
            "state" => self::ORDER_STATE_NEW,
            "status" => self::ORDER_STATUS_PENDING,
            "coupon_code" => $quote->getCouponCode(),
            "protect_code" => $this->protectCode(),
            "shipping_description" => $quote->shipping->description,
            "is_virtual" => 0,
            "store_id" => $store->store_id,
            "customer_id" => null, // ToDo dynamic if not guest,
            "base_discount_amount" => $quote->base_subtotal - $quote->base_subtotal_with_discount,
            "base_grand_total" => $quote->base_grand_total,
            "base_shipping_amount" => "0.0000", // ToDo Shipping from DB
            "base_shipping_tax_amount" => "0.0000", // ToDo Tax Calculation
            "base_subtotal" => $quote->base_subtotal,
            "base_tax_amount" => "0.0000", // ToDo Tax Calculation
            "base_to_global_rate" => "1.0000", // ToDo Must become Dynamic
            "base_to_order_rate" => "1.0000", // ToDo Must become Dynamic
            "base_total_qty_ordered" => null, // ToDo Must become Dynamic
            "discount_amount" => $quote->subtotal - $quote->base_subtotal_with_discount,
            "grand_total" => $quote->base_grand_total,
            "shipping_amount" => "0.0000", // ToDo Get from shipping entity
            "shipping_tax_amount" => "0.0000", // ToDo Tax Calculation
            "store_to_base_rate" => "0.0000", // ToDo Must become Dynamic
            "store_to_order_rate" => "0.0000", // ToDo Must become Dynamic
            "subtotal" => $quote->base_subtotal,
            "tax_amount" => "0.0000", // ToDo Tax Calculation
            "total_qty_ordered" => $quote->items_qty, // todo check
            "can_ship_partially" => 0,
            "can_ship_partially_item" => 0,
            "customer_is_guest" => 1, //ToDo Is set via Checkout Method "als gast"
            "customer_note_notify" => 0, // ToDo make dynamic No idea whats this
            "billing_address_id" => null, // ToDo!! Resave Order
            "customer_group_id" => 0, // Dynamic, if not Guest
            "edit_increment" => 0,// Must become dynamic
            "email_sent" => 0, //ToDo Change after Confirmation sent success event
            "send_email" => 1,  //ToDo Change after Confirmation sent success event
            "forced_shipment_with_invoice" => 0, // ToDo make dynamic
            "payment_auth_expiration" => 0, // ToDo make dynamic
            "quote_address_id" => null, // ToDo make dynamic
            "quote_id" => null, // ToDo make dynamic
            "shipping_address_id" => null, // ToDo!! Resave Order
            "adjustment_negative" => "0.0000", // ToDo Calculate Prices
            "adjustment_positive" => "0.0000", // ToDo Calculate Prices
            "base_adjustment_negative" => "0.0000", // ToDo Calculate Prices
            "base_adjustment_positive" => "0.0000", // ToDo Calculate Prices
            "base_shipping_discount_amount" => "0.0000", // ToDo Calculate Prices
            "base_subtotal_incl_tax" => $quote->base_subtotal, // ToDo Tax Calculation
            "base_total_due" => $quote->base_grand_total,
            "payment_authorization_amount" => null, // ToDo Calculate Prices
            "shipping_discount_amount" => "0.0000", // ToDo Calculate Prices
            "subtotal_incl_tax" => $quote->base_subtotal, // ToDo Tax Calculation
            "total_due" => $quote->base_grand_total, // ToDo Calculate Prices
            "weight" => $this->weight($quote),
            "customer_dob" => null, //ToDo get DateTime if needed
            "increment_id" => $this->incrementId(),
            "applied_rule_ids" => null, //ToDo Must become dynamic
            "base_currency_code" => $quote->base_currency_code,
            "customer_email" => $this->getBillingEmail($quote),
            "customer_firstname" => null, // ToDo dynamic if not guest,
            "customer_lastname" => null, // ToDo dynamic if not guest,
            "customer_middlename" => null, // ToDo dynamic if not guest,
            "customer_prefix" => null, // ToDo dynamic if not guest,
            "customer_suffix" => null, // ToDo dynamic if not guest,
            "customer_taxvat" => null, // ToDo dynamic if not guest,
            "discount_description" => null, // ToDo Must become dynamic,
            "ext_customer_id" => null, // ToDo Must become dynamic,
            "ext_order_id" => null, // ToDo Must become dynamic,
            "global_currency_code" => $quote->store_currency_code, // ToDo doesn't feel right
            "hold_before_state" => null, // ToDo Must become dynamic,
            "hold_before_status" => null, // ToDo Must become dynamic,
            "order_currency_code" => $quote->quote_currency_code,
            "original_increment_id" => null, //ToDo must become dynamic
            "relation_child_id" => null, //ToDo must become dynamic
            "relation_child_real_id" => null, //ToDo must become dynamic
            "relation_parent_id" => null, //ToDo must become dynamic
            "relation_parent_real_id" => null, //ToDo must become dynamic
            "remote_ip" => request()->ip(),
            "shipping_method" => $quote->shipping->method,
            "store_currency_code" => $quote->store_currency_code,
            "store_name" => $fullStoreName,
            "x_forwarded_for" => null, //ToDo must become dynamic
            "customer_note" => null, //ToDo must become dynamic
            "total_item_count" => $quote->getItemsCount(),
            "customer_gender" => null, //ToDo Need to get gender if not guest
            "discount_tax_compensation_amount" => "0.0000", //ToDo ToDo Calculate Prices
            "base_discount_tax_compensation_amount" => "0.0000", //ToDo ToDo Calculate Prices
            "shipping_discount_tax_compensation_amount" => "0.0000", //ToDo ToDo Calculate Prices
            "base_shipping_discount_tax_compensation_amnt" => "0.0000", //ToDo ToDo Calculate Prices
            "shipping_incl_tax" => "0.0000", //ToDo ToDo Calculate Prices
            "base_shipping_incl_tax" => "0.0000", //ToDo ToDo Calculate Prices
            "coupon_rule_name" => null, //ToDo must become dynamic
            "gift_message_id" => null, //ToDo must become dynamic
            "paypal_ipn_customer_notified" => 0, //ToDo must become dynamic
        ];
    }

    protected function getBillingEmail(QuoteSessionObject $quote)
    {
        $addresses = $quote->getAddresses();
        foreach ($addresses as $address) {
            if ($address->address_type == 'billing') {
                return $address->email;
            }
        }
        return null;
    }

    protected function weight($quote)
    {
        return !empty($quote->weight) ? $quote->weight : "0.0000";
    }

}