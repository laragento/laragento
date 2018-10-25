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

    public function isCouponValid($quote)
    {
        $coupon = $this->getActiveCoupon($quote);
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

        $coupon = $this->getActiveCoupon($quote);

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

    /**
     * @param QuoteSessionObject $quote
     * @return mixed
     */
    protected function getActiveCoupon($quote)
    {

        $customerGroupId = $quote->getCustomerGroupId();
        $couponCode = $quote->getCouponCode();
        // check if the sales-rule is active and in date range
        // check if the coupon code is correct
        $this->coupon = SalesRuleCoupon::with('rule.groups')
            ->where('code', $couponCode)
            ->whereHas('rule', function ($query) use ($customerGroupId){
                $query->where('is_active', 1)
                    ->where('coupon_type', SalesRule::SALES_RULE_COUPON_TYPE_WITH_COUPON)
                    ->where('from_date', '<=', date("Y-m-d"))
                    ->where('to_date', '>=', date("Y-m-d"))
                    ->whereHas('groups', function ($query) use ($customerGroupId) {
                        $query->where('customer_group_id', $customerGroupId);
                    });
            })->first();



        return $this->coupon;
    }

    /**
     * @param QuoteSessionObject $quote
     * @return mixed
     */
    protected function getActiveSalesRules($quote)
    {
        $customerGroupId = $quote->getCustomerGroupId();

        return SalesRule::where('is_active', 1)
            ->where('from_date', '<=', date("Y-m-d"))
            ->where('to_date', '>=', date("Y-m-d"))
            ->where('coupon_type', SalesRule::SALES_RULE_COUPON_TYPE_NO_COUPON)
            ->whereHas('groups', function ($query) use ($customerGroupId) {
                $query->where('customer_group_id', $customerGroupId);
            })
            ->get();
    }
}