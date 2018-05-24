<?php


namespace Laragento\Quote\DataObject;


class QuoteSessionItem
{
    /*
protected $item_id
protected $quote_id
protected $created_at
protected $updated_at
protected $product_id
protected $store_id
protected $parent_item_id
protected $is_virtual
protected $sku
protected $name
protected $description
protected $applied_rule_ids
protected $additional_data
protected $is_qty_decimal
protected $no_discount
protected $weight
protected $qty
protected $price
protected $base_price
protected $custom_price
protected $discount_percent
protected $discount_amount
protected $base_discount_amount
protected $tax_percent
protected $tax_amount
protected $base_tax_amount
protected $row_total
protected $base_row_total
protected $row_total_with_discount
protected $row_weight
protected $product_type
protected $base_tax_before_discount
protected $tax_before_discount
protected $original_custom_price
protected $redirect_url
protected $base_cost
protected $price_incl_tax
protected $base_price_incl_tax
protected $row_total_incl_tax
protected $base_row_total_incl_tax
protected $discount_tax_compensation_amount
protected $base_discount_tax_compensation_amount
protected $free_shipping
protected $is_excluded_product
protected $gift_message_id
protected $weee_tax_applied
protected $weee_tax_applied_amount
protected $weee_tax_applied_row_amount
protected $weee_tax_disposition
protected $weee_tax_row_disposition
protected $base_weee_tax_applied_amount
protected $base_weee_tax_applied_row_amnt
protected $base_weee_tax_disposition
protected $base_weee_tax_row_disposition
     */
    protected $item_id;
    protected $product_id;
    protected $qty;
    protected $price;
    protected $base_price;
    protected $custom_price;
    protected $discount_percent;
    protected $discount_amount;
    protected $tax_percent;
    protected $tax_amount;
    protected $row_total;
    protected $row_total_with_discount;
    protected $tax_before_discount;
    protected $price_incl_tax;
    protected $row_total_incl_tax;
    protected $discount_tax_compensation_amount;
    protected $free_shipping;

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * @param mixed $item_id
     */
    public function setItemId($item_id): void
    {
        $this->item_id = $item_id;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId($product_id): void
    {
        $this->product_id = $product_id;
    }

    /**
     * @return mixed
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @param mixed $qty
     */
    public function setQty($qty): void
    {
        $this->qty = $qty;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getBasePrice()
    {
        return $this->base_price;
    }

    /**
     * @param mixed $base_price
     */
    public function setBasePrice($base_price): void
    {
        $this->base_price = $base_price;
    }

    /**
     * @return mixed
     */
    public function getCustomPrice()
    {
        return $this->custom_price;
    }

    /**
     * @param mixed $custom_price
     */
    public function setCustomPrice($custom_price): void
    {
        $this->custom_price = $custom_price;
    }

    /**
     * @return mixed
     */
    public function getDiscountPercent()
    {
        return $this->discount_percent;
    }

    /**
     * @param mixed $discount_percent
     */
    public function setDiscountPercent($discount_percent): void
    {
        $this->discount_percent = $discount_percent;
    }

    /**
     * @return mixed
     */
    public function getDiscountAmount()
    {
        return $this->discount_amount;
    }

    /**
     * @param mixed $discount_amount
     */
    public function setDiscountAmount($discount_amount): void
    {
        $this->discount_amount = $discount_amount;
    }

    /**
     * @return mixed
     */
    public function getTaxPercent()
    {
        return $this->tax_percent;
    }

    /**
     * @param mixed $tax_percent
     */
    public function setTaxPercent($tax_percent): void
    {
        $this->tax_percent = $tax_percent;
    }

    /**
     * @return mixed
     */
    public function getTaxAmount()
    {
        return $this->tax_amount;
    }

    /**
     * @param mixed $tax_amount
     */
    public function setTaxAmount($tax_amount): void
    {
        $this->tax_amount = $tax_amount;
    }

    /**
     * @return mixed
     */
    public function getRowTotal()
    {
        return $this->row_total;
    }

    /**
     * @param mixed $row_total
     */
    public function setRowTotal($row_total): void
    {
        $this->row_total = $row_total;
    }

    /**
     * @return mixed
     */
    public function getRowTotalWithDiscount()
    {
        return $this->row_total_with_discount;
    }

    /**
     * @param mixed $row_total_with_discount
     */
    public function setRowTotalWithDiscount($row_total_with_discount): void
    {
        $this->row_total_with_discount = $row_total_with_discount;
    }

    /**
     * @return mixed
     */
    public function getTaxBeforeDiscount()
    {
        return $this->tax_before_discount;
    }

    /**
     * @param mixed $tax_before_discount
     */
    public function setTaxBeforeDiscount($tax_before_discount): void
    {
        $this->tax_before_discount = $tax_before_discount;
    }

    /**
     * @return mixed
     */
    public function getPriceInclTax()
    {
        return $this->price_incl_tax;
    }

    /**
     * @param mixed $price_incl_tax
     */
    public function setPriceInclTax($price_incl_tax): void
    {
        $this->price_incl_tax = $price_incl_tax;
    }

    /**
     * @return mixed
     */
    public function getRowTotalInclTax()
    {
        return $this->row_total_incl_tax;
    }

    /**
     * @param mixed $row_total_incl_tax
     */
    public function setRowTotalInclTax($row_total_incl_tax): void
    {
        $this->row_total_incl_tax = $row_total_incl_tax;
    }

    /**
     * @return mixed
     */
    public function getDiscountTaxCompensationAmount()
    {
        return $this->discount_tax_compensation_amount;
    }

    /**
     * @param mixed $discount_tax_compensation_amount
     */
    public function setDiscountTaxCompensationAmount($discount_tax_compensation_amount): void
    {
        $this->discount_tax_compensation_amount = $discount_tax_compensation_amount;
    }

    /**
     * @return mixed
     */
    public function getFreeShipping()
    {
        return $this->free_shipping;
    }

    /**
     * @param mixed $free_shipping
     */
    public function setFreeShipping($free_shipping): void
    {
        $this->free_shipping = $free_shipping;
    }

    public function toArray()
    {
        $serialized = (array)$this;
        $search = "\x00*\x00";
        $replacedKeys = str_replace($search, '', array_keys($serialized));

        return array_combine($replacedKeys,$serialized);

    }


}

