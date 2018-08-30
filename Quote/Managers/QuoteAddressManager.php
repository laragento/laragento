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


    protected function mapAddress($address,$email,$addressType)
    {
        return [
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
        return [
            'email' => $addressData['email'],
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

    protected function mapShippingAddress($addressData)
    {
        if(isset($addressData['shipping_address'])){
            return $this->mapAddress(
                $addressData['shipping_address'],
                $addressData['email'],
                'shipping'
            );
        }
        return [
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

        if(isset($addressData['same_as_billing']) && $addressData['same_as_billing'] == 'on'){
            $shippingAddress = $billingAddress;
            $shippingAddress['address_type'] = 'shipping';
        }else{
            $shippingAddress = $this->mapShippingAddress($addressData);
        }

        $addresses[] = $billingAddress;
        $addresses[] = $shippingAddress;

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
     * @return null
     */
    public function getBillingAddress()
    {
        return $this->getAddressByType('billing');
    }

    /**
     * @return null
     */
    public function getShippingAddress()
    {
        return $this->getAddressByType('shipping');
    }



    private function getAddressByType($type)
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