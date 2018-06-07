<?php


namespace Laragento\Quote\DataObject;


/**
 * Class QuoteSessionObject
 * @package Laragento\Quote\DataObject
 */
class QuoteSessionObject
{
    /* ORIGINAL from DB, actually not used

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

    /**
     * @var int
     */
    protected $store_id = 0;
    /**
     * @var bool
     */
    protected $is_active = true;
    /**
     * @var bool
     */
    protected $is_virtual = false;
    /**
     * @var bool
     */
    protected $is_multi_shipping = false;
    /**
     * @var int
     */
    protected $items_count = 0;
    /**
     * @var int
     */
    protected $items_qty = 0;
    /**
     * @var int|null
     */
    protected $orig_order_id;
    /**
     * @var float
     */
    protected $store_to_base_rate = 1;
    /**
     * @var float
     */
    protected $store_to_quote_rate = 1;
    /**
     * @var string
     */
    protected $base_currency_code = "CHF";
    /**
     * @var string
     */
    protected $store_currency_code = "CHF";
    /**
     * @var string
     */
    protected $quote_currency_code = "CHF";
    /**
     * @var string
     */
    protected $grand_total = "0.0000";
    /**
     * @var string
     */
    protected $base_grand_total = "0.0000";
    /**
     * @var int|null
     */
    protected $customer_id;
    /**
     * @var string|null
     */
    protected $remote_ip;
    /**
     * @var string|null
     */
    protected $coupon_code;
    /**
     * @var string
     */
    protected $global_currency_code = "CHF";
    /**
     * @var string
     */
    protected $base_to_global_rate = "1.0000";
    /**
     * @var string
     */
    protected $base_to_quote_rate = "1.0000";
    /**
     * @var string
     */
    protected $subtotal = "0.0000";
    /**
     * @var string
     */
    protected $base_subtotal = "0.0000";
    /**
     * @var string
     */
    protected $subtotal_with_discount = "0.0000";
    /**
     * @var string
     */
    protected $base_subtotal_with_discount = "0.0000";


    // From Sales:
    /**
     * @var string
     */
    protected $shipping_amount = "0.0000";
    /**
     * @var string
     */
    protected $shipping_tax_amount = "0.0000";
    /**
     * @var string
     */
    protected $tax_amount = "0.0000";

    // Object only without corresponding DB-Entry:
    /**
     * @var array
     */
    protected $items = [];
    /**
     * @var string|null
     */
    protected $cart_id;

    /**
     * QuoteSessionObject constructor.
     */
    public function __construct()
    {


    }

    /**
     * @return int
     */
    public function getStoreId(): int
    {
        return $this->store_id;
    }

    /**
     * @param int $store_id
     */
    public function setStoreId(int $store_id): void
    {
        $this->store_id = $store_id;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     */
    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @return bool
     */
    public function isVirtual(): bool
    {
        return $this->is_virtual;
    }

    /**
     * @param bool $is_virtual
     */
    public function setIsVirtual(bool $is_virtual): void
    {
        $this->is_virtual = $is_virtual;
    }

    /**
     * @return bool
     */
    public function isMultiShipping(): bool
    {
        return $this->is_multi_shipping;
    }

    /**
     * @param bool $is_multi_shipping
     */
    public function setIsMultiShipping(bool $is_multi_shipping): void
    {
        $this->is_multi_shipping = $is_multi_shipping;
    }

    /**
     * @return int
     */
    public function getItemsCount(): int
    {
        return $this->items_count;
    }

    /**
     * @param int $items_count
     */
    public function setItemsCount(int $items_count): void
    {
        $this->items_count = $items_count;
    }

    /**
     * @return int
     */
    public function getItemsQty(): int
    {
        return $this->items_qty;
    }

    /**
     * @param int $items_qty
     */
    public function setItemsQty(int $items_qty): void
    {
        $this->items_qty = $items_qty;
    }

    /**
     * @return int|null
     */
    public function getOrigOrderId(): ?int
    {
        return $this->orig_order_id;
    }

    /**
     * @param int|null $orig_order_id
     */
    public function setOrigOrderId(?int $orig_order_id): void
    {
        $this->orig_order_id = $orig_order_id;
    }

    /**
     * @return float
     */
    public function getStoreToBaseRate(): float
    {
        return $this->store_to_base_rate;
    }

    /**
     * @param float $store_to_base_rate
     */
    public function setStoreToBaseRate(float $store_to_base_rate): void
    {
        $this->store_to_base_rate = $store_to_base_rate;
    }

    /**
     * @return float
     */
    public function getStoreToQuoteRate(): float
    {
        return $this->store_to_quote_rate;
    }

    /**
     * @param float $store_to_quote_rate
     */
    public function setStoreToQuoteRate(float $store_to_quote_rate): void
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
     * @return string
     */
    public function getGrandTotal(): string
    {
        return $this->grand_total;
    }

    /**
     * @param string $grand_total
     */
    public function setGrandTotal(string $grand_total): void
    {
        $this->grand_total = $grand_total;
    }

    /**
     * @return string
     */
    public function getBaseGrandTotal(): string
    {
        return $this->base_grand_total;
    }

    /**
     * @param string $base_grand_total
     */
    public function setBaseGrandTotal(string $base_grand_total): void
    {
        $this->base_grand_total = $base_grand_total;
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    /**
     * @param int|null $customer_id
     */
    public function setCustomerId(?int $customer_id): void
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @return null|string
     */
    public function getRemoteIp(): ?string
    {
        return $this->remote_ip;
    }

    /**
     * @param null|string $remote_ip
     */
    public function setRemoteIp(?string $remote_ip): void
    {
        $this->remote_ip = $remote_ip;
    }

    /**
     * @return null|string
     */
    public function getCouponCode(): ?string
    {
        return $this->coupon_code;
    }

    /**
     * @param null|string $coupon_code
     */
    public function setCouponCode(?string $coupon_code): void
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
     * @return string
     */
    public function getBaseToGlobalRate(): string
    {
        return $this->base_to_global_rate;
    }

    /**
     * @param string $base_to_global_rate
     */
    public function setBaseToGlobalRate(string $base_to_global_rate): void
    {
        $this->base_to_global_rate = $base_to_global_rate;
    }

    /**
     * @return string
     */
    public function getBaseToQuoteRate(): string
    {
        return $this->base_to_quote_rate;
    }

    /**
     * @param string $base_to_quote_rate
     */
    public function setBaseToQuoteRate(string $base_to_quote_rate): void
    {
        $this->base_to_quote_rate = $base_to_quote_rate;
    }

    /**
     * @return string
     */
    public function getSubtotal(): string
    {
        return $this->subtotal;
    }

    /**
     * @param string $subtotal
     */
    public function setSubtotal(string $subtotal): void
    {
        $this->subtotal = $subtotal;
    }

    /**
     * @return string
     */
    public function getBaseSubtotal(): string
    {
        return $this->base_subtotal;
    }

    /**
     * @param string $base_subtotal
     */
    public function setBaseSubtotal(string $base_subtotal): void
    {
        $this->base_subtotal = $base_subtotal;
    }

    /**
     * @return string
     */
    public function getSubtotalWithDiscount(): string
    {
        return $this->subtotal_with_discount;
    }

    /**
     * @param string $subtotal_with_discount
     */
    public function setSubtotalWithDiscount(string $subtotal_with_discount): void
    {
        $this->subtotal_with_discount = $subtotal_with_discount;
    }

    /**
     * @return string
     */
    public function getBaseSubtotalWithDiscount(): string
    {
        return $this->base_subtotal_with_discount;
    }

    /**
     * @param string $base_subtotal_with_discount
     */
    public function setBaseSubtotalWithDiscount(string $base_subtotal_with_discount): void
    {
        $this->base_subtotal_with_discount = $base_subtotal_with_discount;
    }

    /**
     * @return string
     */
    public function getShippingAmount(): string
    {
        return $this->shipping_amount;
    }

    /**
     * @param string $shipping_amount
     */
    public function setShippingAmount(string $shipping_amount): void
    {
        $this->shipping_amount = $shipping_amount;
    }

    /**
     * @return string
     */
    public function getShippingTaxAmount(): string
    {
        return $this->shipping_tax_amount;
    }

    /**
     * @param string $shipping_tax_amount
     */
    public function setShippingTaxAmount(string $shipping_tax_amount): void
    {
        $this->shipping_tax_amount = $shipping_tax_amount;
    }

    /**
     * @return string
     */
    public function getTaxAmount(): string
    {
        return $this->tax_amount;
    }

    /**
     * @param string $tax_amount
     */
    public function setTaxAmount(string $tax_amount): void
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

    /**
     * @return null|string
     */
    public function getCartId(): ?string
    {
        return $this->cart_id;
    }

    /**
     * @param null|string $cart_id
     */
    public function setCartId(?string $cart_id = null): void
    {
        if (!$cart_id) {
            $cart_id = $this->generateGUID(true, true);
        }
        $this->cart_id = $cart_id;
    }

    /**
     *
     */
    public function setBAKCartId(): void
    {
        $id = $this->generateGUID(true, true);
        $this->cart_id = $id;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        $serialized = (array)$this;
        $search = "\x00*\x00";
        $replacedKeys = str_replace($search, '', array_keys($serialized));

        return array_combine($replacedKeys,$serialized);

    }

    /**
     * @param $trim
     * @param $upper
     * @param null $hyphen
     * @return string
     */
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