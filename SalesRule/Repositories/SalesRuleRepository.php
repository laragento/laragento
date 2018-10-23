<?php

namespace Laragento\SalesRule\Repositories;


use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\SalesRule\DataObjects\RuleInterface;
use Laragento\SalesRule\Exceptions\NegativeSubtotalException;
use Laragento\SalesRule\Models\SalesRule;
use Laragento\SalesRule\Models\SalesRuleCoupon;

/**
 * Class SalesRuleRepository
 * @package Laragento\SalesRule\Repositories
 */
class SalesRuleRepository implements SalesRuleRepositoryInterface
{
    /**
     * @var null
     */
    protected $coupon = null;

    /**
     * @var RuleInterface
     */
    protected $rule;


    public function __construct(
        RuleInterface $rule
    ) {
        $this->rule = $rule;
    }

    public function isCouponValid($couponCode)
    {
        $coupon = $this->getActiveCoupon($couponCode);
        if (!$coupon) {
            return false;
        }
        return true;
    }


    /**
     * @param QuoteSessionObject $quote
     * @return RuleInterface[]
     * @throws NegativeSubtotalException
     */
    public function rules(QuoteSessionObject $quote)
    {
        $salesRules = $this->getActiveSalesRules($quote);
        $salesRules[] = $this->getActiveSalesCoupon($quote);
        return $salesRules;
    }

    /**
     * @param QuoteSessionObject $quote
     * @return RuleInterface
     * @throws NegativeSubtotalException
     */
    public function getActiveSalesCoupon(QuoteSessionObject $quote)
    {

        $coupon = $this->getActiveCoupon($quote->getCouponCode());

        $subtotal = $quote->getBaseSubtotal();

        // when the cart subtotal is zero
        if ($subtotal == 0) {
            return $this->rule;
        }

        // when there is no active coupon
        if (!$coupon) {
            return $this->rule;
        }

        // get the discount amount
        $discountAmount = $coupon->rule->discount_amount;
        if ($discountAmount == 0) {
            return $this->rule;
        }

        // the coupon code can't be applied if the subtotal is smaller than discount
        if ($coupon->rule->discount_amount >= $subtotal) {
            throw new NegativeSubtotalException('quote_cant_be_less_than_zero');
        }

        $this->rule->discount_amount = $discountAmount;
        $this->rule->active = true;
        return $this->rule;
    }

    protected function getActiveCoupon($couponCode)
    {
        // check if the sales-rule is active and in date range
        // check if the coupon code is correct
        $this->coupon = SalesRuleCoupon::with('rule.groups')
            ->where('code', $couponCode)
            ->whereHas('rule', function ($query) {
                $query->where('is_active', 1)
                    ->where('from_date', '<=', date("Y-m-d"))
                    ->where('to_date', '>=', date("Y-m-d"));
            })->first();

        return $this->coupon;
    }

    protected function getActiveSalesRules($quote)
    {
        return SalesRule::where('is_active', 1)
            ->where('from_date', '<=', date("Y-m-d"))
            ->where('to_date', '>=', date("Y-m-d"))
            ->where('coupon_type', '1')
            ->get();
    }
}