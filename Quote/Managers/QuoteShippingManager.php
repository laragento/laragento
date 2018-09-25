<?php


namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\DataObjects\QuoteSessionShipping;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;

class QuoteShippingManager
{
    protected $quoteDataRepository;

    //ToDo Must become Shipping Module getting values from Database & XML File
    protected $shippingMethods =
        [
            'priority' => [
                'shipping_description' => 'A-Post',
                'base_shipping_amount_inkl_tax' => '1.00'
            ],
            'economy' => [
                'shipping_description' => 'B-Post',
                'base_shipping_amount_inkl_tax' => '0.85'
            ],
            'express' => [
                'shipping_description' => 'Express',
                'base_shipping_amount_inkl_tax' => '5.00'
            ],
            'pickup' => [
                'shipping_description' => 'Abholung',
                'base_shipping_amount_inkl_tax' => '0.00'
            ]
        ];

    /**
     * QuotePaymentManager constructor.
     * @param QuoteSessionObjectRepositoryInterface $quoteDataRepository
     */
    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository
    ) {
        $this->quoteDataRepository = $quoteDataRepository;
    }

    /**
     * @return QuoteSessionObject
     */
    public function getQuote()
    {
        return $this->quoteDataRepository->getQuote();
    }

    /**
     * @param $shippingMethod
     */
    public function setShippingMethod($shippingMethodId)
    {
        $allShippingMethods = $this->getAvailableShippingMethods();
        $shippingMethod = $allShippingMethods[$shippingMethodId];
        //if(!$this->isActive())
        //{
        //throw shippingMethodIsNotActiveException
        //throw shippingMethodIsNotExistentException
        //}
        $quote = $this->getQuote();
        $shipping = new QuoteSessionShipping();
        $shipping->setMethod($shippingMethodId);
        $shipping->setDescription($shippingMethod['shipping_description']);
        $shipping->setPrice($shippingMethod['base_shipping_amount_inkl_tax']);
        $quote->setShipping($shipping);
    }

    /**
     * @return mixed
     */
    public function getShippingMethod()
    {
        $quote = $this->getQuote();
        if(is_object($quote->shipping)){
            return $quote->shipping;
        }
        return null;
    }

    public function getAvailableShippingMethods()
    {
        return $this->shippingMethods;
    }


}