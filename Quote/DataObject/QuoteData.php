<?php


namespace Laragento\Quote\DataObject;


class QuoteData
{
    /* ORIGINAL from DB
    protected $entity_id;
    protected $store_id;
    protected $created_at;
    protected $updated_at;
    protected $converted_at;
    protected $is_active;
    protected $is_virtual;
    protected $is_multi_shipping;
    protected $items_count;
    protected $items_qty;
    protected $orig_order_id;
    protected $store_to_base_rate;
    protected $store_to_quote_rate;
    protected $base_currency_code;
    protected $store_currency_code;
    protected $quote_currency_code;
    protected $grand_total;
    protected $base_grand_total;
    protected $checkout_method;
    protected $customer_id;
    protected $customer_tax_class_id;
    protected $customer_group_id;
    protected $customer_email;
    protected $customer_prefix;
    protected $customer_firstname;
    protected $customer_middlename;
    protected $customer_lastname;
    protected $customer_suffix;
    protected $customer_dob;
    protected $customer_note;
    protected $customer_note_notify;
    protected $customer_is_guest;
    protected $remote_ip;
    protected $applied_rule_ids;
    protected $reserved_order_id;
    protected $password_hash;
    protected $coupon_code;
    protected $global_currency_code;
    protected $base_to_global_rate;
    protected $base_to_quote_rate;
    protected $customer_taxvat;
    protected $customer_gender;
    protected $subtotal;
    protected $base_subtotal;
    protected $subtotal_with_discount;
    protected $base_subtotal_with_discount;
    protected $is_changed;
    protected $trigger_recollect;
    protected $ext_shipping_info;
    protected $is_persistent;
    protected $gift_message_id;
    */

    protected $store_id;
    protected $created_at;
    protected $updated_at;
    protected $items_count;
    protected $items_qty;
    protected $quote_currency_code;
    protected $customer_id;
    protected $remote_ip;
    protected $coupon_code;
    protected $base_to_quote_rate;
    protected $customer_taxvat;
    protected $grand_total;
    protected $subtotal;
    protected $base_subtotal;
    protected $subtotal_with_discount;
    protected $base_subtotal_with_discount;

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->store_id;
    }

    /**
     * @param mixed $store_id
     */
    public function setStoreId($store_id): void
    {
        $this->store_id = $store_id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getItemsCount()
    {
        return $this->items_count;
    }

    /**
     * @param mixed $items_count
     */
    public function setItemsCount($items_count): void
    {
        $this->items_count = $items_count;
    }

    /**
     * @return mixed
     */
    public function getItemsQty()
    {
        return $this->items_qty;
    }

    /**
     * @param mixed $items_qty
     */
    public function setItemsQty($items_qty): void
    {
        $this->items_qty = $items_qty;
    }

    /**
     * @return mixed
     */
    public function getQuoteCurrencyCode()
    {
        return $this->quote_currency_code;
    }

    /**
     * @param mixed $quote_currency_code
     */
    public function setQuoteCurrencyCode($quote_currency_code): void
    {
        $this->quote_currency_code = $quote_currency_code;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param mixed $customer_id
     */
    public function setCustomerId($customer_id): void
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @return mixed
     */
    public function getRemoteIp()
    {
        return $this->remote_ip;
    }

    /**
     * @param mixed $remote_ip
     */
    public function setRemoteIp($remote_ip): void
    {
        $this->remote_ip = $remote_ip;
    }

    /**
     * @return mixed
     */
    public function getCouponCode()
    {
        return $this->coupon_code;
    }

    /**
     * @param mixed $coupon_code
     */
    public function setCouponCode($coupon_code): void
    {
        $this->coupon_code = $coupon_code;
    }

    /**
     * @return mixed
     */
    public function getBaseToQuoteRate()
    {
        return $this->base_to_quote_rate;
    }

    /**
     * @param mixed $base_to_quote_rate
     */
    public function setBaseToQuoteRate($base_to_quote_rate): void
    {
        $this->base_to_quote_rate = $base_to_quote_rate;
    }

    /**
     * @return mixed
     */
    public function getCustomerTaxvat()
    {
        return $this->customer_taxvat;
    }

    /**
     * @param mixed $customer_taxvat
     */
    public function setCustomerTaxvat($customer_taxvat): void
    {
        $this->customer_taxvat = $customer_taxvat;
    }

    /**
     * @return mixed
     */
    public function getGrandTotal()
    {
        return $this->grand_total;
    }

    /**
     * @param mixed $grand_total
     */
    public function setGrandTotal($grand_total): void
    {
        $this->grand_total = $grand_total;
    }

    /**
     * @return mixed
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * @param mixed $subtotal
     */
    public function setSubtotal($subtotal): void
    {
        $this->subtotal = $subtotal;
    }

    /**
     * @return mixed
     */
    public function getBaseSubtotal()
    {
        return $this->base_subtotal;
    }

    /**
     * @param mixed $base_subtotal
     */
    public function setBaseSubtotal($base_subtotal): void
    {
        $this->base_subtotal = $base_subtotal;
    }

    /**
     * @return mixed
     */
    public function getSubtotalWithDiscount()
    {
        return $this->subtotal_with_discount;
    }

    /**
     * @param mixed $subtotal_with_discount
     */
    public function setSubtotalWithDiscount($subtotal_with_discount): void
    {
        $this->subtotal_with_discount = $subtotal_with_discount;
    }

    /**
     * @return mixed
     */
    public function getBaseSubtotalWithDiscount()
    {
        return $this->base_subtotal_with_discount;
    }

    /**
     * @param mixed $base_subtotal_with_discount
     */
    public function setBaseSubtotalWithDiscount($base_subtotal_with_discount): void
    {
        $this->base_subtotal_with_discount = $base_subtotal_with_discount;
    }


}