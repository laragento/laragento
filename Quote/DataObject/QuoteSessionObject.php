<?php


namespace Laragento\Quote\DataObject;


use Illuminate\Support\Facades\Auth;

class QuoteSessionObject
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

    protected $cart_id;
    protected $store_id = 1;
    protected $items_count = 0;
    protected $items_qty = 0;
    protected $items = [];
    protected $quote_currency_code = 'CHF';
    protected $customer_id;
    protected $remote_ip;
    protected $coupon_code;
    protected $grand_total = 0.0000;
    protected $subtotal = 0.0000;
    protected $base_subtotal = 0.0000;
    protected $subtotal_with_discount = 0.0000;
    protected $base_subtotal_with_discount = 0.0000;

    public function __construct()
    {
        if (!$this->getCartId()) {
            $this->setCartId($this->generateGUID(true, false));
        }
        if (Auth::user() && !$this->getCustomerId()) {
            $this->setCustomerId(Auth::user()['entity_id']);
        }
        if (!$this->getRemoteIp()) {
            $this->setRemoteIp(request()->ip());
        }
        dd($this->toArray());


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
    public function setCartId($cart_id): void
    {
        $this->cart_id = $cart_id;
    }


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