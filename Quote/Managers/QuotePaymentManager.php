<?php
namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\DataObjects\QuoteSessionPayment;
use Laragento\Quote\Exceptions\MethodNotFoundException;
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
     * @throws MethodNotFoundException
     */
    public function storePaymentByCode(String $code)
    {
        $paymentMethod = $this->getPaymentMethodByCode($code);
        if(!$paymentMethod){
            throw new MethodNotFoundException();
        }
        $payment = new QuoteSessionPayment();
        $payment->setMethod($code);
        $payment->setAdditionalInformation('{"method_title":"'.$paymentMethod->description().'"}');
        $this->storePayment($payment);
    }

    /**
     * @return array
     */
    protected function collectPaymentMethods()
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
     * @return QuoteSessionObject
     */
    protected function getQuote()
    {
        return $this->quoteDataRepository->getQuote();
    }
}