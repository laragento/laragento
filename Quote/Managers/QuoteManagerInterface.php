<?php


namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;

interface QuoteManagerInterface
{
    /**
     * @return QuoteSessionObject
     */
    public function getQuote();

    /**
     * @param QuoteSessionObject $quote
     */
    public function calculateTotals($quote);

    /**
     * @param $quote
     * @param $taxes
     * @return mixed
     */
    public function setAdditionalCartInfo($quote,$taxes);

    /**
     * @param $couponCode
     * @return mixed
     */
    public function updateCouponCode($couponCode);

    /**
     * @return mixed
     */
    public function removeCouponCode();

}