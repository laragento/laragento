<?php

namespace Laragento\Customer\Observers;


use Laragento\Customer\Models\Address;

class AddressObserver
{
    /**
     * @param Address $address
     */
    public function deleting(Address $address)
    {
        $customer = $address->customer;

        if($customer->default_billing == $address->getKey()){
            $customer->default_billing = null;
            $customer->save();
        }

        if($customer->default_shipping == $address->getKey()){
            $customer->default_shipping = null;
            $customer->save();
        }
    }
}