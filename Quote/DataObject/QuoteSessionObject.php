<?php


namespace Laragento\Quote\DataObject;


class QuoteSessionObject
{
    /* ORIGINAL from DB
    protected $created_at;
    protected $updated_at;
    protected $converted_at;
    protected $checkout_method;
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
    protected $applied_rule_ids;
    protected $reserved_order_id;
    protected $password_hash;
    protected $customer_taxvat;
    protected $customer_gender;
    protected $is_changed;
    protected $trigger_recollect;
    protected $ext_shipping_info;
    protected $is_persistent;
    protected $gift_message_id;
    */

    protected $created_at;
    protected $updated_at;
    protected $converted_at;
    protected $is_active = 1;
    protected $is_virtual = 0;
    protected $is_multi_shipping = 0;
    protected $items_count;
    protected $items_qty;
    protected $orig_order_id;
    protected $store_to_base_rate;
    protected $store_to_quote_rate;
    protected $base_currency_code = "CHF";
    protected $store_currency_code = "CHF";
    protected $quote_currency_code = "CHF";
    protected $grand_total = 0.0000;
    protected $base_grand_total = 0.0000;
    protected $customer_id;
    protected $remote_ip;
    protected $coupon_code;
    protected $global_currency_code = "CHF";
    protected $base_to_global_rate = 1.0000;
    protected $base_to_quote_rate = 1.0000;
    protected $subtotal = 0.0000;
    protected $base_subtotal = 0.0000;
    protected $subtotal_with_discount = 0.0000;
    protected $base_subtotal_with_discount = 0.0000;


    // From Sales:
    protected $shipping_amount = 0.0000;
    protected $shipping_tax_amount = 0.0000;
    protected $tax_amount = 0.0000;

    // Object only:
    protected $items = [];
    protected $cart_id;

    public function __construct()
    {


    }

    /**
     * @return mixed
     */
    public function getCartId()
    {
        return $this->cart_id;
    }

    /**
     * @param mixed $cart_id
     */
    public function setCartId(): void
    {
        $cart_id = $this->generateGUID(true, false);
        $this->cart_id = $cart_id;
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
    public function getConvertedAt()
    {
        return $this->converted_at;
    }

    /**
     * @param mixed $converted_at
     */
    public function setConvertedAt($converted_at): void
    {
        $this->converted_at = $converted_at;
    }

    /**
     * @return int
     */
    public function getisActive(): int
    {
        return $this->is_active;
    }

    /**
     * @param int $is_active
     */
    public function setIsActive(int $is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @return int
     */
    public function getisVirtual(): int
    {
        return $this->is_virtual;
    }

    /**
     * @param int $is_virtual
     */
    public function setIsVirtual(int $is_virtual): void
    {
        $this->is_virtual = $is_virtual;
    }

    /**
     * @return int
     */
    public function getisMultiShipping(): int
    {
        return $this->is_multi_shipping;
    }

    /**
     * @param int $is_multi_shipping
     */
    public function setIsMultiShipping(int $is_multi_shipping): void
    {
        $this->is_multi_shipping = $is_multi_shipping;
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
    public function getOrigOrderId()
    {
        return $this->orig_order_id;
    }

    /**
     * @param mixed $orig_order_id
     */
    public function setOrigOrderId($orig_order_id): void
    {
        $this->orig_order_id = $orig_order_id;
    }

    /**
     * @return mixed
     */
    public function getStoreToBaseRate()
    {
        return $this->store_to_base_rate;
    }

    /**
     * @param mixed $store_to_base_rate
     */
    public function setStoreToBaseRate($store_to_base_rate): void
    {
        $this->store_to_base_rate = $store_to_base_rate;
    }

    /**
     * @return mixed
     */
    public function getStoreToQuoteRate()
    {
        return $this->store_to_quote_rate;
    }

    /**
     * @param mixed $store_to_quote_rate
     */
    public function setStoreToQuoteRate($store_to_quote_rate): void
    {
        $this->store_to_quote_rate = $store_to_quote_rate;
    }

    /**
     * @return string
     */
    public function getBaseCurrencyCode(): string
    {
        return $this->base_currency_code;
    }

    /**
     * @param string $base_currency_code
     */
    public function setBaseCurrencyCode(string $base_currency_code): void
    {
        $this->base_currency_code = $base_currency_code;
    }

    /**
     * @return string
     */
    public function getStoreCurrencyCode(): string
    {
        return $this->store_currency_code;
    }

    /**
     * @param string $store_currency_code
     */
    public function setStoreCurrencyCode(string $store_currency_code): void
    {
        $this->store_currency_code = $store_currency_code;
    }

    /**
     * @return string
     */
    public function getQuoteCurrencyCode(): string
    {
        return $this->quote_currency_code;
    }

    /**
     * @param string $quote_currency_code
     */
    public function setQuoteCurrencyCode(string $quote_currency_code): void
    {
        $this->quote_currency_code = $quote_currency_code;
    }

    /**
     * @return float
     */
    public function getGrandTotal(): float
    {
        return $this->grand_total;
    }

    /**
     * @param float $grand_total
     */
    public function setGrandTotal(float $grand_total): void
    {
        $this->grand_total = $grand_total;
    }

    /**
     * @return float
     */
    public function getBaseGrandTotal(): float
    {
        return $this->base_grand_total;
    }

    /**
     * @param float $base_grand_total
     */
    public function setBaseGrandTotal(float $base_grand_total): void
    {
        $this->base_grand_total = $base_grand_total;
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
     * @return string
     */
    public function getGlobalCurrencyCode(): string
    {
        return $this->global_currency_code;
    }

    /**
     * @param string $global_currency_code
     */
    public function setGlobalCurrencyCode(string $global_currency_code): void
    {
        $this->global_currency_code = $global_currency_code;
    }

    /**
     * @return float
     */
    public function getBaseToGlobalRate(): float
    {
        return $this->base_to_global_rate;
    }

    /**
     * @param float $base_to_global_rate
     */
    public function setBaseToGlobalRate(float $base_to_global_rate): void
    {
        $this->base_to_global_rate = $base_to_global_rate;
    }

    /**
     * @return float
     */
    public function getBaseToQuoteRate(): float
    {
        return $this->base_to_quote_rate;
    }

    /**
     * @param float $base_to_quote_rate
     */
    public function setBaseToQuoteRate(float $base_to_quote_rate): void
    {
        $this->base_to_quote_rate = $base_to_quote_rate;
    }

    /**
     * @return float
     */
    public function getSubtotal(): float
    {
        return $this->subtotal;
    }

    /**
     * @param float $subtotal
     */
    public function setSubtotal(float $subtotal): void
    {
        $this->subtotal = $subtotal;
    }

    /**
     * @return float
     */
    public function getBaseSubtotal(): float
    {
        return $this->base_subtotal;
    }

    /**
     * @param float $base_subtotal
     */
    public function setBaseSubtotal(float $base_subtotal): void
    {
        $this->base_subtotal = $base_subtotal;
    }

    /**
     * @return float
     */
    public function getSubtotalWithDiscount(): float
    {
        return $this->subtotal_with_discount;
    }

    /**
     * @param float $subtotal_with_discount
     */
    public function setSubtotalWithDiscount(float $subtotal_with_discount): void
    {
        $this->subtotal_with_discount = $subtotal_with_discount;
    }

    /**
     * @return float
     */
    public function getBaseSubtotalWithDiscount(): float
    {
        return $this->base_subtotal_with_discount;
    }

    /**
     * @param float $base_subtotal_with_discount
     */
    public function setBaseSubtotalWithDiscount(float $base_subtotal_with_discount): void
    {
        $this->base_subtotal_with_discount = $base_subtotal_with_discount;
    }

    /**
     * @return float
     */
    public function getShippingAmount(): float
    {
        return $this->shipping_amount;
    }

    /**
     * @param float $shipping_amount
     */
    public function setShippingAmount(float $shipping_amount): void
    {
        $this->shipping_amount = $shipping_amount;
    }

    /**
     * @return float
     */
    public function getShippingTaxAmount(): float
    {
        return $this->shipping_tax_amount;
    }

    /**
     * @param float $shipping_tax_amount
     */
    public function setShippingTaxAmount(float $shipping_tax_amount): void
    {
        $this->shipping_tax_amount = $shipping_tax_amount;
    }

    /**
     * @return float
     */
    public function getTaxAmount(): float
    {
        return $this->tax_amount;
    }

    /**
     * @param float $tax_amount
     */
    public function setTaxAmount(float $tax_amount): void
    {
        $this->tax_amount = $tax_amount;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }



    public function toArray()
    {
        $serialized = (array)$this;
        $search = "\x00*\x00";
        $replacedKeys = str_replace($search, '', array_keys($serialized));

        return array_combine($replacedKeys,$serialized);

    }

    private function generateGUID($trim, $upper, $hyphen = null)
    {
        mt_srand((double)microtime() * 10000);
        $charid = md5(uniqid(rand(), true));
        $beginn = '';
        $end = '';

        if ($upper) {
            $charid = strtoupper($charid);
        }
        if ($hyphen) {
            $hyphen = chr(45);
        }

        if (!$trim) {
            $beginn = chr(123);
            $end = chr(125);
        }
        $uuid = $beginn
            . substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12)
            . $end;

        return $uuid;
    }


}