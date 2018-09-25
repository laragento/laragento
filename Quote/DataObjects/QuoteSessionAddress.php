<?php


namespace Laragento\Quote\DataObjects;

class QuoteSessionAddress
{
    protected $address_id;
    protected $quote_id;
    protected $customer_id = null;
    protected $save_in_address_book;
    protected $customer_address_id;
    protected $address_type; // "billing","shipping"
    protected $email;
    protected $prefix;
    protected $firstname;
    protected $middlename;
    protected $lastname;
    protected $suffix;
    protected $company;
    protected $street;
    protected $city;
    protected $region;
    protected $region_id;
    protected $postcode;
    protected $country_id;
    protected $telephone;
    protected $fax;
    protected $same_as_billing;
    protected $collect_shipping_rates;
    protected $shipping_method;
    protected $shipping_description;
    protected $weight;
    protected $subtotal = '0.0000';
    protected $base_subtotal = '0.0000';
    protected $subtotal_with_discount = '0.0000';
    protected $base_subtotal_with_discount = '0.0000';
    protected $tax_amount = '0.0000';
    protected $base_tax_amount = '0.0000';
    protected $shipping_amount = '0.0000';
    protected $base_shipping_amount = '0.0000';
    protected $shipping_tax_amount = '0.0000';
    protected $base_shipping_tax_amount = '0.0000';
    protected $discount_amount = '0.0000';
    protected $base_discount_amount = '0.0000';
    protected $grand_total = '0.0000';
    protected $base_grand_total = '0.0000';
    protected $customer_notes;
    protected $applied_taxes;
    protected $discount_description;
    protected $shipping_discount_amount = '0.0000';
    protected $base_shipping_discount_amount = '0.0000';
    protected $subtotal_incl_tax = '0.0000';
    protected $base_subtotal_incl_tax = '0.0000';
    protected $discount_tax_compensation_amount = '0.0000';
    protected $base_discount_tax_compensation_amount = '0.0000';
    protected $shipping_discount_tax_compensation_amount = '0.0000';
    protected $base_shipping_discount_tax_compensation_amount = '0.0000';
    protected $shipping_incl_tax = '0.0000';
    protected $base_shipping_incl_tax = '0.0000';
    protected $free_shipping;
    protected $vat_id;
    protected $vat_is_valid;
    protected $vat_request_id;
    protected $vat_request_date;
    protected $vat_request_success;
    protected $gift_message_id;

    /**
     * @return mixed
     */
    public function getAddressId()
    {
        return $this->address_id;
    }

    /**
     * @param mixed $address_id
     */
    public function setAddressId($address_id): void
    {
        $this->address_id = $address_id;
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
    public function getSaveInAddressBook()
    {
        return $this->save_in_address_book;
    }

    /**
     * @param mixed $save_in_address_book
     */
    public function setSaveInAddressBook($save_in_address_book): void
    {
        $this->save_in_address_book = $save_in_address_book;
    }

    /**
     * @return mixed
     */
    public function getCustomerAddressId()
    {
        return $this->customer_address_id;
    }

    /**
     * @param mixed $customer_address_id
     */
    public function setCustomerAddressId($customer_address_id): void
    {
        $this->customer_address_id = $customer_address_id;
    }

    /**
     * @return mixed
     */
    public function getAddressType()
    {
        return $this->address_type;
    }

    /**
     * @param mixed $address_type
     */
    public function setAddressType($address_type): void
    {
        $this->address_type = $address_type;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param mixed $prefix
     */
    public function setPrefix($prefix): void
    {
        $this->prefix = $prefix;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * @param mixed $middlename
     */
    public function setMiddlename($middlename): void
    {
        $this->middlename = $middlename;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @param mixed $suffix
     */
    public function setSuffix($suffix): void
    {
        $this->suffix = $suffix;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company): void
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street): void
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region): void
    {
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getRegionId()
    {
        return $this->region_id;
    }

    /**
     * @param mixed $region_id
     */
    public function setRegionId($region_id): void
    {
        $this->region_id = $region_id;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param mixed $postcode
     */
    public function setPostcode($postcode): void
    {
        $this->postcode = $postcode;
    }

    /**
     * @return mixed
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * @param mixed $country_id
     */
    public function setCountryId($country_id): void
    {
        $this->country_id = $country_id;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax): void
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getSameAsBilling()
    {
        return $this->same_as_billing;
    }

    /**
     * @param mixed $same_as_billing
     */
    public function setSameAsBilling($same_as_billing): void
    {
        $this->same_as_billing = $same_as_billing;
    }

    /**
     * @return mixed
     */
    public function getCollectShippingRates()
    {
        return $this->collect_shipping_rates;
    }

    /**
     * @param mixed $collect_shipping_rates
     */
    public function setCollectShippingRates($collect_shipping_rates): void
    {
        $this->collect_shipping_rates = $collect_shipping_rates;
    }

    /**
     * @return mixed
     */
    public function getShippingMethod()
    {
        return $this->shipping_method;
    }

    /**
     * @param mixed $shipping_method
     */
    public function setShippingMethod($shipping_method): void
    {
        $this->shipping_method = $shipping_method;
    }

    /**
     * @return mixed
     */
    public function getShippingDescription()
    {
        return $this->shipping_description;
    }

    /**
     * @param mixed $shipping_description
     */
    public function setShippingDescription($shipping_description): void
    {
        $this->shipping_description = $shipping_description;
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
    public function getBaseTaxAmount()
    {
        return $this->base_tax_amount;
    }

    /**
     * @param mixed $base_tax_amount
     */
    public function setBaseTaxAmount($base_tax_amount): void
    {
        $this->base_tax_amount = $base_tax_amount;
    }

    /**
     * @return mixed
     */
    public function getShippingAmount()
    {
        return $this->shipping_amount;
    }

    /**
     * @param mixed $shipping_amount
     */
    public function setShippingAmount($shipping_amount): void
    {
        $this->shipping_amount = $shipping_amount;
    }

    /**
     * @return mixed
     */
    public function getBaseShippingAmount()
    {
        return $this->base_shipping_amount;
    }

    /**
     * @param mixed $base_shipping_amount
     */
    public function setBaseShippingAmount($base_shipping_amount): void
    {
        $this->base_shipping_amount = $base_shipping_amount;
    }

    /**
     * @return mixed
     */
    public function getShippingTaxAmount()
    {
        return $this->shipping_tax_amount;
    }

    /**
     * @param mixed $shipping_tax_amount
     */
    public function setShippingTaxAmount($shipping_tax_amount): void
    {
        $this->shipping_tax_amount = $shipping_tax_amount;
    }

    /**
     * @return mixed
     */
    public function getBaseShippingTaxAmount()
    {
        return $this->base_shipping_tax_amount;
    }

    /**
     * @param mixed $base_shipping_tax_amount
     */
    public function setBaseShippingTaxAmount($base_shipping_tax_amount): void
    {
        $this->base_shipping_tax_amount = $base_shipping_tax_amount;
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
    public function getBaseDiscountAmount()
    {
        return $this->base_discount_amount;
    }

    /**
     * @param mixed $base_discount_amount
     */
    public function setBaseDiscountAmount($base_discount_amount): void
    {
        $this->base_discount_amount = $base_discount_amount;
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
    public function getBaseGrandTotal()
    {
        return $this->base_grand_total;
    }

    /**
     * @param mixed $base_grand_total
     */
    public function setBaseGrandTotal($base_grand_total): void
    {
        $this->base_grand_total = $base_grand_total;
    }

    /**
     * @return mixed
     */
    public function getCustomerNotes()
    {
        return $this->customer_notes;
    }

    /**
     * @param mixed $customer_notes
     */
    public function setCustomerNotes($customer_notes): void
    {
        $this->customer_notes = $customer_notes;
    }

    /**
     * @return mixed
     */
    public function getAppliedTaxes()
    {
        return $this->applied_taxes;
    }

    /**
     * @param mixed $applied_taxes
     */
    public function setAppliedTaxes($applied_taxes): void
    {
        $this->applied_taxes = $applied_taxes;
    }

    /**
     * @return mixed
     */
    public function getDiscountDescription()
    {
        return $this->discount_description;
    }

    /**
     * @param mixed $discount_description
     */
    public function setDiscountDescription($discount_description): void
    {
        $this->discount_description = $discount_description;
    }

    /**
     * @return mixed
     */
    public function getShippingDiscountAmount()
    {
        return $this->shipping_discount_amount;
    }

    /**
     * @param mixed $shipping_discount_amount
     */
    public function setShippingDiscountAmount($shipping_discount_amount): void
    {
        $this->shipping_discount_amount = $shipping_discount_amount;
    }

    /**
     * @return mixed
     */
    public function getBaseShippingDiscountAmount()
    {
        return $this->base_shipping_discount_amount;
    }

    /**
     * @param mixed $base_shipping_discount_amount
     */
    public function setBaseShippingDiscountAmount($base_shipping_discount_amount): void
    {
        $this->base_shipping_discount_amount = $base_shipping_discount_amount;
    }

    /**
     * @return mixed
     */
    public function getSubtotalInclTax()
    {
        return $this->subtotal_incl_tax;
    }

    /**
     * @param mixed $subtotal_incl_tax
     */
    public function setSubtotalInclTax($subtotal_incl_tax): void
    {
        $this->subtotal_incl_tax = $subtotal_incl_tax;
    }

    /**
     * @return mixed
     */
    public function getBaseSubtotalInclTax()
    {
        return $this->base_subtotal_incl_tax;
    }

    /**
     * @param mixed $base_subtotal_incl_tax
     */
    public function setBaseSubtotalInclTax($base_subtotal_incl_tax): void
    {
        $this->base_subtotal_incl_tax = $base_subtotal_incl_tax;
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
    public function getBaseDiscountTaxCompensationAmount()
    {
        return $this->base_discount_tax_compensation_amount;
    }

    /**
     * @param mixed $base_discount_tax_compensation_amount
     */
    public function setBaseDiscountTaxCompensationAmount($base_discount_tax_compensation_amount): void
    {
        $this->base_discount_tax_compensation_amount = $base_discount_tax_compensation_amount;
    }

    /**
     * @return mixed
     */
    public function getShippingDiscountTaxCompensationAmount()
    {
        return $this->shipping_discount_tax_compensation_amount;
    }

    /**
     * @param mixed $shipping_discount_tax_compensation_amount
     */
    public function setShippingDiscountTaxCompensationAmount($shipping_discount_tax_compensation_amount): void
    {
        $this->shipping_discount_tax_compensation_amount = $shipping_discount_tax_compensation_amount;
    }

    /**
     * @return mixed
     */
    public function getBaseShippingDiscountTaxCompensationAmount()
    {
        return $this->base_shipping_discount_tax_compensation_amount;
    }

    /**
     * @param mixed $base_shipping_discount_tax_compensation_amount
     */
    public function setBaseShippingDiscountTaxCompensationAmount($base_shipping_discount_tax_compensation_amount): void
    {
        $this->base_shipping_discount_tax_compensation_amount = $base_shipping_discount_tax_compensation_amount;
    }

    /**
     * @return mixed
     */
    public function getShippingInclTax()
    {
        return $this->shipping_incl_tax;
    }

    /**
     * @param mixed $shipping_incl_tax
     */
    public function setShippingInclTax($shipping_incl_tax): void
    {
        $this->shipping_incl_tax = $shipping_incl_tax;
    }

    /**
     * @return mixed
     */
    public function getBaseShippingInclTax()
    {
        return $this->base_shipping_incl_tax;
    }

    /**
     * @param mixed $base_shipping_incl_tax
     */
    public function setBaseShippingInclTax($base_shipping_incl_tax): void
    {
        $this->base_shipping_incl_tax = $base_shipping_incl_tax;
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


    // Object only
    protected $customAttributes = [];

    /**
     * @param $prop
     * @return mixed
     */
    public function __get($prop)
    {
        return $this->$prop;
    }

    /**
     * @param $prop
     * @return mixed
     */
    public function __set($prop)
    {
        return $this->$prop;
    }

    /**
     * @param $prop
     * @return bool
     */
    public function __isset($prop) : bool
    {
        return isset($this->$prop);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $serialized = (array)$this;
        $search = "\x00*\x00";
        $replacedKeys = str_replace($search, '', array_keys($serialized));

        return array_combine($replacedKeys, $serialized);
    }
}

