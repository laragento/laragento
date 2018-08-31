<?php

namespace Laragento\Sales\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Store\Models\Store;

class GuestOrderManager extends AbstractOrderManager
{
    /**
     * @param QuoteSessionObject $quote
     * @return array
     */
    protected function mapQuoteToOrder($quote)
    {
        $orderData = $this->getAbstractQuoteToOrderData($quote);
        $orderData['customer_id'] = null;
        $orderData['customer_group_id'] = 0;
        $orderData['customer_dob'] = null;
        $orderData['customer_email'] = $this->getBillingEmail($quote);
        $orderData['customer_firstname'] = null;
        $orderData['customer_middlename'] = null;
        $orderData['customer_lastname'] = null;
        $orderData['customer_prefix'] = null;
        $orderData['customer_suffix'] = null;
        $orderData['customer_gender'] = null;

    }

    protected function getBillingEmail(QuoteSessionObject $quote)
    {
        $addresses = $quote->getAddresses();
        foreach ($addresses as $address) {
            if ($address->address_type == 'billing') {
                return $address->email;
            }
        }
        return null;
    }

}