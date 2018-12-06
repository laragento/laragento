<?php


namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\DataObjects\QuoteSessionShipping;
use Laragento\Quote\Exceptions\MethodNotFoundException;
use Laragento\Quote\Managers\PaymentProviders\PaymentProviderInterface;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;

class QuoteShippingManager
{
    protected $quoteManager;
    protected $quoteDataRepository;
    protected $shippingMethods = [];

    /**
     * QuotePaymentManager constructor.
     *
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
     * @param $shippingMethodCode
     * @throws MethodNotFoundException
     */
    public function setShippingMethod($shippingMethodCode)
    {
        $allShippingMethods = $this->getAvailableShippingMethods();
        if(empty($allShippingMethods) || !isset($allShippingMethods[$shippingMethodCode])){
            throw new MethodNotFoundException('shipping_method_not_found');
        }
        $shippingMethod = $allShippingMethods[$shippingMethodCode];
        $quote = $this->getQuote();
        $shipping = new QuoteSessionShipping();
        $shipping->setMethod($shippingMethodCode);
        $shipping->setDescription($shippingMethod->description());
        $shipping->setPrice($shippingMethod->price());
        $quote->setShipping($shipping);
        $this->calculateTotals($quote);
    }

    /**
     * @return PaymentProviderInterface[]
     */
    public function getAvailableShippingMethods()
    {
        if (empty($this->shippingMethods)) {
            $this->collectShippingMethods();
        }
        return $this->shippingMethods;
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

    /**
     * @return array
     */
    protected function collectShippingMethods()
    {
        $shippingMethodClasses = config('quote.shipping_providers');
        foreach ($shippingMethodClasses as $shippingMethodClass) {
            $methodClass = new $shippingMethodClass($this->getQuote());
            if ($methodClass->isAvailable()) {
                $this->shippingMethods[$methodClass->code()] = $methodClass;
            }
        }
        return $this->shippingMethods;
    }

    /**
     * @return QuoteSessionObject
     */
    protected function getQuote()
    {
        return $this->quoteDataRepository->getQuote();
    }

    /**
     * @param $quote
     */
    protected function calculateTotals($quote)
    {
        if (config('quote.calculateTotals') == true) {
            $this->quoteManager->calculateTotals($quote);
        }
    }
}