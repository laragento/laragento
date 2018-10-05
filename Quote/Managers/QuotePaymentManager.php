<?php
namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\DataObjects\QuoteSessionPayment;
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

    /**
     * @return array
     */
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

    /**
     * @return QuoteSessionPayment[]
     */
    public function getAvailablePaymentMethods()
    {
        if (empty($this->paymentMethods)) {
            $this->collectPaymentMethods();
        }
        return $this->paymentMethods;
    }

    /**
     * @param $code
     * @return bool|QuoteSessionPayment
     */
    public function getPaymentMethodByCode(String $code)
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
     * @param String $code
     */
    public function storePaymentByCode(String $code)
    {
        $paymentMethod = $this->getPaymentMethodByCode($code);
        $payment = new QuoteSessionPayment();
        $payment->setMethod($code);
        $payment->setAdditionalInformation('{"method_title":"'.$paymentMethod->description().'"}');
        $this->storePayment($payment);
    }

    /**
     * @param QuoteSessionPayment $payment
     */
    public function storePayment(QuoteSessionPayment $payment)
    {
        $quote = $this->getQuote();
        $quote->setPayment($payment);
    }

    /**
     * @return \Laragento\Quote\DataObjects\QuoteSessionPayment
     */
    public function getPayment() : QuoteSessionPayment
    {
        $quote = $this->getQuote();
        return $quote->getPayment();
    }

}