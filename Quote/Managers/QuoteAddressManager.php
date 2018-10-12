<?php

namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionAddress;
use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\DataObjects\QuoteSessionShipping;
use Laragento\Quote\Repositories\QuoteSessionAddressRepositoryInterface;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;

class QuoteAddressManager
{
    protected $quoteDataRepository;
    protected $quoteAddressRepository;

    /**
     * QuoteAddressManager constructor.
     * @param QuoteSessionObjectRepositoryInterface $quoteDataRepository
     * @param QuoteSessionAddressRepositoryInterface $quoteAddressRepository
     */
    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository,
        QuoteSessionAddressRepositoryInterface $quoteAddressRepository
    ) {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->quoteAddressRepository = $quoteAddressRepository;
    }

    /**
     * @return QuoteSessionObject
     */
    public function getQuote()
    {
        return $this->quoteDataRepository->getQuote();
    }


    /**
     * @param $address
     * @param $email
     * @param $addressType
     * @return array
     */
    protected function mapAddress($address,$email,$addressType)
    {
        return [
            'customer_id' => $address->parent_id,
            'customer_address_id' => $address->entity_id,
            'email' => $email,
            'firstname' => $address->firstname,
            'lastname' => $address->lastname,
            'company' => $address->company,
            'street' => $address->street,
            'postcode' => $address->postcode,
            'city' => $address->city,
            'country_id' => $address->country_id,
            'telephone' => $address->telephone,
            'address_type' => $addressType,
        ];
    }

    /**
     * @param $addressData
     * @return array
     */
    protected function  mapBillingAddress($addressData)
    {
        if(isset($addressData['billing_address'])){
            return $this->mapAddress(
                $addressData['billing_address'],
                $addressData['email'],
                'billing'
            );
        }

        if(isset($addressData['prefix'])){
            $prefix = $addressData['prefix'];
        }else
        {
            $prefix = "";
        }

        return [
            'email' => $addressData['email'],
            'prefix' => $prefix,
            'firstname' => $addressData['firstname'],
            'lastname' => $addressData['lastname'],
            'company' => $addressData['company'],
            'street' => $addressData['street'],
            'postcode' => $addressData['postcode'],
            'city' => $addressData['city'],
            'country_id' => $addressData['country_id'],
            'telephone' => $addressData['telephone'],
            'address_type' => 'billing',
        ];
    }

    /**
     * @param $addressData
     * @return array
     */
    protected function mapShippingAddress($addressData)
    {
        if(isset($addressData['shipping_address'])){
            return $this->mapAddress(
                $addressData['shipping_address'],
                $addressData['email'],
                'shipping'
            );
        }

        if(isset($addressData['prefix'])){
            $prefix = $addressData['prefix'];
        }else
        {
            $prefix = "";
        }

        return [
            'prefix' => $prefix,
            'firstname' => $addressData['shipping_firstname'],
            'lastname' => $addressData['shipping_lastname'],
            'company' => $addressData['shipping_company'],
            'street' => $addressData['shipping_street'],
            'postcode' => $addressData['shipping_postcode'],
            'city' => $addressData['shipping_city'],
            'country_id' => $addressData['shipping_country_id'],
            'telephone' => $addressData['shipping_telephone'],
            'address_type' => 'shipping',
        ];
    }

    /**
     * @param $addressData
     * @return array
     */
    public function updateAddresses($addressData)
    {
        $billingAddress = $this->mapBillingAddress($addressData);

        if (!isset($addressData['same_as_billing']) && !isset($addressData['shipping_address'])) {
            $shippingAddress = null;
        } else {
            if(isset($addressData['same_as_billing']) && $addressData['same_as_billing'] == 'on'){
                $shippingAddress = $billingAddress;
                $shippingAddress['address_type'] = 'shipping';
                $shippingAddress['same_as_billing'] = 1;
            }else{
                $shippingAddress = $this->mapShippingAddress($addressData);
                $shippingAddress['same_as_billing'] = 0;
            }
        }


        $addresses[] = $billingAddress;
        if ($shippingAddress) {
            $addresses[] = $shippingAddress;
        }

        $storedAddresses = [];
        $quote = $this->getQuote();
        foreach ($addresses as $key => $address) {
            $storedAddresses[] = $this->createAddressDataObject($address);
        }
        $quote->setAddresses($storedAddresses);
        $quote->setShipping(new QuoteSessionShipping());
        return $quote->getAddresses();
    }

    /**
     * @param $address
     * @return mixed
     */
    public function createAddressDataObject($address)
    {
        return $this->quoteAddressRepository->create($address);
    }

    /**
     * @return QuoteSessionAddress
     */
    public function getBillingAddress() : QuoteSessionAddress
    {
        return $this->getAddressByType('billing');
    }

    /**
     * @return QuoteSessionAddress
     */
    public function getShippingAddress() : QuoteSessionAddress
    {
        return $this->getAddressByType('shipping');
    }
    
    /**
     * @param $type
     * @return QuoteSessionAddress
     */
    private function getAddressByType($type) : QuoteSessionAddress
    {
        $quote = $this->getQuote();
        $addresses = $quote->getAddresses();
        foreach ($addresses as $address) {
            if (isset($address->address_type ) && $address->address_type  == $type) {
                return $address;
            }
        }
        return new QuoteSessionAddress();
    }
}