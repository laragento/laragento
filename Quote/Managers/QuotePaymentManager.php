<?php


namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;

class QuotePaymentManager
{
    protected $quoteDataRepository;
    protected $paymentMethods = [];

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


    public function collectPaymentMethods()
    {
        $paymentMethodClasses = config('quote.payment_providers');
        foreach ($paymentMethodClasses as $paymentMethodClass) {
            $methodClass = new $paymentMethodClass($this->getQuote());
            if ($methodClass->isAvailable()) {
                $this->paymentMethods[] = $methodClass;
            }
        }
        return $this->paymentMethods;
    }

    public function getAvailablePaymentMethods()
    {
        if (empty($this->paymentMethods)) {
            $this->collectPaymentMethods();
        }
        return $this->paymentMethods;
    }

    public function getPaymentMethodByCode($code)
    {
        if (empty($this->paymentMethods)) {
            $this->collectPaymentMethods();
        }
        foreach ($this->paymentMethods as $paymentMethod){
            if($paymentMethod->code() == $code)
            {
                return $paymentMethod;
            }
        }
        return false;
    }

    /**
     * @param $payment
     */
    public function storePayment($payment)
    {
        $quote = $this->getQuote();
        $quote->setPayment($payment);
    }

    /**
     *
     */
    public function getPayment()
    {
        $quote = $this->getQuote();
        return $quote->getPayment();
    }

}