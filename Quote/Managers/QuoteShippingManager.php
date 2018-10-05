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
    protected $shippingProviders = [];

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
        $shipping->setDescription($shippingMethod->description());
        $shipping->setPrice($shippingMethod->price());
        $quote->setShipping($shipping);
        $this->calculateTotals($quote);
    }

    /**
     * @return mixed
     */
    public function getShippingMethod()
    {
        $quote = $this->getQuote();
        if (is_object($quote->shipping)) {
            return $quote->shipping;
        }
        return null;
    }

    public function collectShippingMethods()
    {
        $shippingMethodClasses = config('quote.shipping_providers');
        foreach ($shippingMethodClasses as $shippingMethodClass) {
            $methodClass = new $shippingMethodClass($this->getQuote());
            if ($methodClass->isAvailable()) {
                $this->shippingMethods[] = $methodClass;
            }
        }
        return $this->shippingMethods;
    }

    public function getAvailableShippingMethods()
    {
        if (empty($this->shippingMethods)) {
            $this->collectShippingMethods();
        }
        return $this->shippingMethods;
    }

    public function calculateTotals($quote)
    {
        $this->quoteManager->calculateTotals($quote);
    }
}