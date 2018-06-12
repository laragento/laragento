<?php


namespace Laragento\Quote\DataObject;


class QuoteSessionItem
{
    /* ORIGINAL from DB, actually not used

    protected $created_at;
    protected $updated_at;
    protected $parent_item_id;
    protected $applied_rule_ids;
    protected $additional_data;
    protected $is_qty_decimal;
    protected $no_discount;
    protected $product_type;
    protected $base_tax_before_discount;
    protected $tax_before_discount;
    protected $base_cost;
    protected $gift_message_id;
    protected $weee_tax_applied;
    protected $weee_tax_applied_amount;
    protected $weee_tax_applied_row_amount;
    protected $weee_tax_disposition;
    protected $weee_tax_row_disposition;
    protected $base_weee_tax_applied_amount;
    protected $base_weee_tax_applied_row_amnt;
    protected $base_weee_tax_disposition;
    protected $base_weee_tax_row_disposition;
     */

    protected $item_id;
    protected $quote_id;
    protected $product_id;
    protected $store_id;
    protected $is_virtual;
    protected $sku;
    protected $name;
    protected $description;
    protected $weight;
    protected $qty;
    protected $price = '0.0000';
    protected $base_price = '0.0000';
    protected $custom_price = '0.0000';
    protected $discount_percent = '0.0000';
    protected $discount_amount = '0.0000';
    protected $base_discount_amount = '0.0000';
    protected $tax_percent = '0.0000';
    protected $tax_amount = '0.0000';
    protected $base_tax_amount = '0.0000';
    protected $row_total = '0.0000';
    protected $base_row_total = '0.0000';
    protected $row_total_with_discount = '0.0000';
    protected $row_weight;
    protected $original_custom_price;
    protected $redirect_url;
    protected $price_incl_tax = '0.0000';
    protected $base_price_incl_tax = '0.0000';
    protected $row_total_incl_tax = '0.0000';
    protected $base_row_total_incl_tax = '0.0000';
    protected $discount_tax_compensation_amount = '0.0000';
    protected $base_discount_tax_compensation_amount = '0.0000';
    protected $free_shipping = 0;

    public function __get($prop)
    {
        return $this->$prop;
    }

    public function __isset($prop) : bool
    {
        return isset($this->$prop);
    }

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
    public function getQuoteId()
    {
        return $this->quote_id;
    }

    /**
     * @param mixed $quote_id
     */
    public function setQuoteId($quote_id): void
    {
        $this->quote_id = $quote_id;
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
    public function getisVirtual()
    {
        return $this->is_virtual;
    }

    /**
     * @param mixed $is_virtual
     */
    public function setIsVirtual($is_virtual): void
    {
        $this->is_virtual = $is_virtual;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
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
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getBasePrice(): string
    {
        return $this->base_price;
    }

    /**
     * @param string $base_price
     */
    public function setBasePrice(string $base_price): void
    {
        $this->base_price = $base_price;
    }

    /**
     * @return string
     */
    public function getCustomPrice(): string
    {
        return $this->custom_price;
    }

    /**
     * @param string $custom_price
     */
    public function setCustomPrice(string $custom_price): void
    {
        $this->custom_price = $custom_price;
    }

    /**
     * @return string
     */
    public function getDiscountPercent(): string
    {
        return $this->discount_percent;
    }

    /**
     * @param string $discount_percent
     */
    public function setDiscountPercent(string $discount_percent): void
    {
        $this->discount_percent = $discount_percent;
    }

    /**
     * @return string
     */
    public function getDiscountAmount(): string
    {
        return $this->discount_amount;
    }

    /**
     * @param string $discount_amount
     */
    public function setDiscountAmount(string $discount_amount): void
    {
        $this->discount_amount = $discount_amount;
    }

    /**
     * @return string
     */
    public function getBaseDiscountAmount(): string
    {
        return $this->base_discount_amount;
    }

    /**
     * @param string $base_discount_amount
     */
    public function setBaseDiscountAmount(string $base_discount_amount): void
    {
        $this->base_discount_amount = $base_discount_amount;
    }

    /**
     * @return string
     */
    public function getTaxPercent(): string
    {
        return $this->tax_percent;
    }

    /**
     * @param string $tax_percent
     */
    public function setTaxPercent(string $tax_percent): void
    {
        $this->tax_percent = $tax_percent;
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
     * @return string
     */
    public function getBaseTaxAmount(): string
    {
        return $this->base_tax_amount;
    }

    /**
     * @param string $base_tax_amount
     */
    public function setBaseTaxAmount(string $base_tax_amount): void
    {
        $this->base_tax_amount = $base_tax_amount;
    }

    /**
     * @return string
     */
    public function getRowTotal(): string
    {
        return $this->row_total;
    }

    /**
     * @param string $row_total
     */
    public function setRowTotal(string $row_total): void
    {
        $this->row_total = $row_total;
    }

    /**
     * @return string
     */
    public function getBaseRowTotal(): string
    {
        return $this->base_row_total;
    }

    /**
     * @param string $base_row_total
     */
    public function setBaseRowTotal(string $base_row_total): void
    {
        $this->base_row_total = $base_row_total;
    }

    /**
     * @return string
     */
    public function getRowTotalWithDiscount(): string
    {
        return $this->row_total_with_discount;
    }

    /**
     * @param string $row_total_with_discount
     */
    public function setRowTotalWithDiscount(string $row_total_with_discount): void
    {
        $this->row_total_with_discount = $row_total_with_discount;
    }

    /**
     * @return mixed
     */
    public function getRowWeight()
    {
        return $this->row_weight;
    }

    /**
     * @param mixed $row_weight
     */
    public function setRowWeight($row_weight): void
    {
        $this->row_weight = $row_weight;
    }

    /**
     * @return mixed
     */
    public function getOriginalCustomPrice()
    {
        return $this->original_custom_price;
    }

    /**
     * @param mixed $original_custom_price
     */
    public function setOriginalCustomPrice($original_custom_price): void
    {
        $this->original_custom_price = $original_custom_price;
    }

    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        return $this->redirect_url;
    }

    /**
     * @param mixed $redirect_url
     */
    public function setRedirectUrl($redirect_url): void
    {
        $this->redirect_url = $redirect_url;
    }

    /**
     * @return string
     */
    public function getPriceInclTax(): string
    {
        return $this->price_incl_tax;
    }

    /**
     * @param string $price_incl_tax
     */
    public function setPriceInclTax(string $price_incl_tax): void
    {
        $this->price_incl_tax = $price_incl_tax;
    }

    /**
     * @return string
     */
    public function getBasePriceInclTax(): string
    {
        return $this->base_price_incl_tax;
    }

    /**
     * @param string $base_price_incl_tax
     */
    public function setBasePriceInclTax(string $base_price_incl_tax): void
    {
        $this->base_price_incl_tax = $base_price_incl_tax;
    }

    /**
     * @return string
     */
    public function getRowTotalInclTax(): string
    {
        return $this->row_total_incl_tax;
    }

    /**
     * @param string $row_total_incl_tax
     */
    public function setRowTotalInclTax(string $row_total_incl_tax): void
    {
        $this->row_total_incl_tax = $row_total_incl_tax;
    }

    /**
     * @return string
     */
    public function getBaseRowTotalInclTax(): string
    {
        return $this->base_row_total_incl_tax;
    }

    /**
     * @param string $base_row_total_incl_tax
     */
    public function setBaseRowTotalInclTax(string $base_row_total_incl_tax): void
    {
        $this->base_row_total_incl_tax = $base_row_total_incl_tax;
    }

    /**
     * @return string
     */
    public function getDiscountTaxCompensationAmount(): string
    {
        return $this->discount_tax_compensation_amount;
    }

    /**
     * @param string $discount_tax_compensation_amount
     */
    public function setDiscountTaxCompensationAmount(string $discount_tax_compensation_amount): void
    {
        $this->discount_tax_compensation_amount = $discount_tax_compensation_amount;
    }

    /**
     * @return string
     */
    public function getBaseDiscountTaxCompensationAmount(): string
    {
        return $this->base_discount_tax_compensation_amount;
    }

    /**
     * @param string $base_discount_tax_compensation_amount
     */
    public function setBaseDiscountTaxCompensationAmount(string $base_discount_tax_compensation_amount): void
    {
        $this->base_discount_tax_compensation_amount = $base_discount_tax_compensation_amount;
    }

    /**
     * @return int
     */
    public function getFreeShipping(): int
    {
        return $this->free_shipping;
    }

    /**
     * @param int $free_shipping
     */
    public function setFreeShipping(int $free_shipping): void
    {
        $this->free_shipping = $free_shipping;
    }

    public function toArray()
    {
        $serialized = (array)$this;
        $search = "\x00*\x00";
        $replacedKeys = str_replace($search, '', array_keys($serialized));

        return array_combine($replacedKeys, $serialized);

    }


}

