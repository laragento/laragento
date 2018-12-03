<?php


namespace Laragento\Sales\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Store\Models\Store;

class CustomerOrderManager extends AbstractOrderManager implements OrderManagerInterface
{
    /**
     * @param QuoteSessionObject $quote
     * @return array
     */
    protected function mapQuoteToOrder($quote)
    {
        $customer = $quote->customer();
        $orderData = $this->getAbstractQuoteToOrderData($quote);
        $orderData['customer_id'] = $customer->entity_id;
        $orderData['customer_group_id'] = $customer->group_id;
        $orderData['customer_dob'] = $customer->dob;
        $orderData['customer_email'] = $customer->email;
        $orderData['customer_firstname'] = $customer->firstname;
        $orderData['customer_middlename'] = $customer->middlename;
        $orderData['customer_lastname'] = $customer->lastname;
        $orderData['customer_prefix'] = $customer->prefix;
        $orderData['customer_suffix'] = $customer->suffix;
        $orderData['customer_gender'] = $customer->gender;

        return $orderData;
    }
}