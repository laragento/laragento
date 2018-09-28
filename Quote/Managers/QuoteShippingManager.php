<?php


namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\DataObjects\QuoteSessionShipping;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;

class QuoteShippingManager
{
    protected $quoteDataRepository;

    //ToDo Must become Shipping Module getting values from Database & XML File
    protected $shippingMethods = [];



    protected $quoteManager;

    /**
     * QuotePaymentManager constructor.
     * @param QuoteSessionObjectRepositoryInterface $quoteDataRepository
     * @param QuoteManager $quoteManager
     */
    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository,
        QuoteManager $quoteManager
    ) {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->quoteManager = $quoteManager;
    }

    /**
     * @return QuoteSessionObject
     */
    public function getQuote()
    {
        return $this->quoteDataRepository->getQuote();
    }

    /**
     * @param $shippingMethodId
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
        $shipping->setPrice($shippingMethod['base_shipping_amount_incl_tax']);
        $quote->setShipping($shipping);

        $this->calculateTotals($quote);
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

    public function setShippingMethods($shippingMethods)
    {
        return $this->shippingMethods = $shippingMethods;
    }

    public function getAvailableShippingMethods()
    {
        $methods = [];
        foreach ($this->shippingMethods as $shippingMethodClass)
        {
            $methodClass = new $shippingMethodClass($this->getQuote());
            if($methodClass->isAvailable()){
                $methods[] = $methodClass;
            }
        }
        return $methods;
    }

    public function calculateTotals($quote)
    {
        $this->quoteManager->calculateTotals($quote);
    }
}