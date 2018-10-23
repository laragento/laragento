<?php
namespace Laragento\SalesRule\DataObjects;

/**
 * Class Rule
 * @package Laragento\SalesRule\DataObjects
 */
class Rule implements RuleInterface
{
    protected $discount_amount = 0.00;
    protected $active = false;
    protected $title = '';
    protected $discount_percent = 0.00;

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
    public function toArray()
    {
        $serialized = (array)$this;
        $search = "\x00*\x00";
        $replacedKeys = str_replace($search, '', array_keys($serialized));

        return array_combine($replacedKeys,$serialized);

    }
}