<?php


namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;

class QuotePaymentManager
{
    protected $quoteDataRepository;

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