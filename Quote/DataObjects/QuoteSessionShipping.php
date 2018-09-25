<?php

namespace Laragento\Quote\DataObjects;

/**
 * Class QuoteSessionShipping
 * @package Laragento\Quote\DataObjects
 *
 * @property string method
 * @property string description
 * @property string price
 *
 */
class QuoteSessionShipping
{

    protected $method;
    protected $description;
    protected $price;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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
    public function __isset($prop): bool
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

