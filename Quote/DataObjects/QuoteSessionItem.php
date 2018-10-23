<?php


namespace Laragento\Quote\DataObjects;

use Laragento\Catalog\Repositories\Product\ProductRepository;

/**
 * QuoteSessionItem model
 * @property int item_id
 * @property int quote_id
 * @property int store_id
 * @property int product_id
 * @property string sku
 * @property string name
 * @property string description
 * @property string qty
 * @property float weight
 * @property float price
 * @property float base_price
 * @property float tax_percent
 * @property float tax_amount
 * @property float base_tax_amount
 * @property int discount_percent
 * @property float discount_amount
 * @property float base_discount_amount
 * @property float row_total
 * @property float base_row_total
 * @property float row_weight
 * @property float price_incl_tax
 * @property float base_price_incl_tax
 * @property float row_total_incl_tax
 * @property float base_row_total_incl_tax
 * @property int free_shipping
 */

class QuoteSessionItem
{
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
    protected $parent_item_id;
    protected $applied_rule_ids;
    protected $additional_data;
    protected $is_qty_decimal = 0;
    protected $no_discount = 0;
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

    // Object only
    protected $customAttributes = [];

    public function __get($prop)
    {
        return $this->$prop;
    }

    public function __set($prop, $value)
    {
        $this->$prop = $value;
    }

    public function __isset($prop) : bool
    {
        return isset($this->$prop);
    }

    /**
     * @return array
     */
    public function getCustomAttributes(): array
    {
        return $this->customAttributes;
    }

    /**
     * @param array $customAttributes
     */
    public function setCustomAttributes(array $customAttributes): void
    {
        $this->customAttributes = $customAttributes;
    }

    public function product()
    {
        return ProductRepository::productBySku($this->sku);
    }



    public function toArray()
    {
        $serialized = (array)$this;
        $search = "\x00*\x00";
        $replacedKeys = str_replace($search, '', array_keys($serialized));

        return array_combine($replacedKeys, $serialized);

    }

    /*****
     *
     * We keep this methods for legacy reasons:
     * Projects without magic getter/setter methods
     *
     */

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
     * @return mixed
     */
    public function getAdditionalData()
    {
        return $this->additional_data;
    }

    /**
     * @param mixed $additional_data
     */
    public function setAdditionalData($additional_data): void
    {
        $this->additional_data = $additional_data;
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


    /**
     * @return mixed
     */
    public function getParentItemId()
    {
        return $this->parent_item_id;
    }

    /**
     * @param mixed $parent_item_id
     */
    public function setParentItemId($parent_item_id): void
    {
        $this->parent_item_id = $parent_item_id;
    }

    /**
     * @return mixed
     */
    public function getAppliedRuleIds()
    {
        return $this->applied_rule_ids;
    }

    /**
     * @param mixed $applied_rule_ids
     */
    public function setAppliedRuleIds($applied_rule_ids): void
    {
        $this->applied_rule_ids = $applied_rule_ids;
    }

    /**
     * @return int
     */
    public function getisQtyDecimal(): int
    {
        return $this->is_qty_decimal;
    }

    /**
     * @param int $is_qty_decimal
     */
    public function setIsQtyDecimal(int $is_qty_decimal): void
    {
        $this->is_qty_decimal = $is_qty_decimal;
    }

    /**
     * @return int
     */
    public function getNoDiscount(): int
    {
        return $this->no_discount;
    }

    /**
     * @param int $no_discount
     */
    public function setNoDiscount(int $no_discount): void
    {
        $this->no_discount = $no_discount;
    }

    /**
     * @return mixed
     */
    public function getProductType()
    {
        return $this->product_type;
    }

    /**
     * @param mixed $product_type
     */
    public function setProductType($product_type): void
    {
        $this->product_type = $product_type;
    }

    /**
     * @return mixed
     */
    public function getBaseTaxBeforeDiscount()
    {
        return $this->base_tax_before_discount;
    }

    /**
     * @param mixed $base_tax_before_discount
     */
    public function setBaseTaxBeforeDiscount($base_tax_before_discount): void
    {
        $this->base_tax_before_discount = $base_tax_before_discount;
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
    public function getBaseCost()
    {
        return $this->base_cost;
    }

    /**
     * @param mixed $base_cost
     */
    public function setBaseCost($base_cost): void
    {
        $this->base_cost = $base_cost;
    }

    /**
     * @return mixed
     */
    public function getGiftMessageId()
    {
        return $this->gift_message_id;
    }

    /**
     * @param mixed $gift_message_id
     */
    public function setGiftMessageId($gift_message_id): void
    {
        $this->gift_message_id = $gift_message_id;
    }

    /**
     * @return mixed
     */
    public function getWeeeTaxApplied()
    {
        return $this->weee_tax_applied;
    }

    /**
     * @param mixed $weee_tax_applied
     */
    public function setWeeeTaxApplied($weee_tax_applied): void
    {
        $this->weee_tax_applied = $weee_tax_applied;
    }

    /**
     * @return mixed
     */
    public function getWeeeTaxAppliedAmount()
    {
        return $this->weee_tax_applied_amount;
    }

    /**
     * @param mixed $weee_tax_applied_amount
     */
    public function setWeeeTaxAppliedAmount($weee_tax_applied_amount): void
    {
        $this->weee_tax_applied_amount = $weee_tax_applied_amount;
    }

    /**
     * @return mixed
     */
    public function getWeeeTaxAppliedRowAmount()
    {
        return $this->weee_tax_applied_row_amount;
    }

    /**
     * @param mixed $weee_tax_applied_row_amount
     */
    public function setWeeeTaxAppliedRowAmount($weee_tax_applied_row_amount): void
    {
        $this->weee_tax_applied_row_amount = $weee_tax_applied_row_amount;
    }

    /**
     * @return mixed
     */
    public function getWeeeTaxDisposition()
    {
        return $this->weee_tax_disposition;
    }

    /**
     * @param mixed $weee_tax_disposition
     */
    public function setWeeeTaxDisposition($weee_tax_disposition): void
    {
        $this->weee_tax_disposition = $weee_tax_disposition;
    }

    /**
     * @return mixed
     */
    public function getWeeeTaxRowDisposition()
    {
        return $this->weee_tax_row_disposition;
    }

    /**
     * @param mixed $weee_tax_row_disposition
     */
    public function setWeeeTaxRowDisposition($weee_tax_row_disposition): void
    {
        $this->weee_tax_row_disposition = $weee_tax_row_disposition;
    }

    /**
     * @return mixed
     */
    public function getBaseWeeeTaxAppliedAmount()
    {
        return $this->base_weee_tax_applied_amount;
    }

    /**
     * @param mixed $base_weee_tax_applied_amount
     */
    public function setBaseWeeeTaxAppliedAmount($base_weee_tax_applied_amount): void
    {
        $this->base_weee_tax_applied_amount = $base_weee_tax_applied_amount;
    }

    /**
     * @return mixed
     */
    public function getBaseWeeeTaxAppliedRowAmnt()
    {
        return $this->base_weee_tax_applied_row_amnt;
    }

    /**
     * @param mixed $base_weee_tax_applied_row_amnt
     */
    public function setBaseWeeeTaxAppliedRowAmnt($base_weee_tax_applied_row_amnt): void
    {
        $this->base_weee_tax_applied_row_amnt = $base_weee_tax_applied_row_amnt;
    }

    /**
     * @return mixed
     */
    public function getBaseWeeeTaxDisposition()
    {
        return $this->base_weee_tax_disposition;
    }

    /**
     * @param mixed $base_weee_tax_disposition
     */
    public function setBaseWeeeTaxDisposition($base_weee_tax_disposition): void
    {
        $this->base_weee_tax_disposition = $base_weee_tax_disposition;
    }

    /**
     * @return mixed
     */
    public function getBaseWeeeTaxRowDisposition()
    {
        return $this->base_weee_tax_row_disposition;
    }

    /**
     * @param mixed $base_weee_tax_row_disposition
     */
    public function setBaseWeeeTaxRowDisposition($base_weee_tax_row_disposition): void
    {
        $this->base_weee_tax_row_disposition = $base_weee_tax_row_disposition;
    }
}

