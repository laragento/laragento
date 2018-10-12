<?php

namespace Laragento\SalesRule\Repositories;


use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\SalesRule\Models\SalesRuleCoupon;

class SalesRuleRepository implements SalesRuleRepositoryInterface
{
    protected $coupon = null;


    public function isCouponValid($couponCode)
    {
        $coupon = $this->getActiveCoupon($couponCode);
        if(!$coupon){
            return false;
        }
        return true;
    }

    public function discount(QuoteSessionObject $quote)
    {
        $coupon = $this->getActiveCoupon($quote->getCouponCode());

        // when there is no active coupon
        if(!$coupon){
            return 0.0;
        }
        // the coupon code can't be applied if the subtotal is smaller than discount
        dd($quote->getBaseSubtotal());

        return $coupon->rule->discount_amount;
    }

    protected function getActiveCoupon($couponCode){
        // check if the sales-rule is active and in date range
        // check if the coupon code is correct
        $this->coupon = SalesRuleCoupon::with('rule.groups')
            ->where('code',$couponCode)
            ->whereHas('rule',function($query){
                $query->where('is_active',1)
                    ->where('from_date','<=',date("Y-m-d"))
                    ->where('to_date','>=',date("Y-m-d"));
            })->first();

        return $this->coupon;
    }
}