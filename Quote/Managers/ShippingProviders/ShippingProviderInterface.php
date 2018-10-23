<?php

namespace Laragento\Quote\Managers\ShippingProviders;

interface ShippingProviderInterface{
    /**
     * @return bool
     */
    public function isAvailable();

    /**
     * @return float
     */
    public function price();

    /**
     * @return string
     */
    public function code();

    /**
     * @return string
     */
    public function description();
}