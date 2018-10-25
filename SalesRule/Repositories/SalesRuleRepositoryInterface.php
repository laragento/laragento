<?php
namespace Laragento\SalesRule\Repositories;


use Laragento\Quote\DataObjects\QuoteSessionObject;

interface SalesRuleRepositoryInterface
{
    /**
     * @param QuoteSessionObject $quote
     * @return mixed
     */
    public function isCouponValid($quote);

    /**
     * @param QuoteSessionObject $quote
     * @return mixed
     */
    public function rules(QuoteSessionObject $quote);

    /**
     * @param QuoteSessionObject $quote
     * @return mixed
     */
    public function getActiveSalesCoupon(QuoteSessionObject $quote);
}