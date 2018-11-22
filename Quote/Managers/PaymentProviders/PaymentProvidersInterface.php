<?php

namespace Laragento\Quote\Managers\PaymentProviders;

interface PaymentProviderInterface{
    /**
     * @return bool
     */
    public function isAvailable();

    /**
     * @return mixed
     */
    public function hasRedirect();

    /**
     * @return mixed
     */
    public function redirect();

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