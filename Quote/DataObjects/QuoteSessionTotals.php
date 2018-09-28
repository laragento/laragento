<?php


namespace Laragento\Quote\DataObjects;


class QuoteSessionTotals
{
    protected $taxAmount;
    protected $taxPercent;
    protected $discount;
    protected $shipping;


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
     * @return mixed
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * @param mixed $taxAmount
     */
    public function setTaxAmount($taxAmount): void
    {
        $this->taxAmount = $taxAmount;
    }

    /**
     * @return mixed
     */
    public function getTaxPercent()
    {
        return $this->taxPercent;
    }

    /**
     * @param mixed $taxPercent
     */
    public function setTaxPercent($taxPercent): void
    {
        $this->taxPercent = $taxPercent;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return mixed
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param mixed $shipping
     */
    public function setShipping($shipping): void
    {
        $this->shipping = $shipping;
    }


}