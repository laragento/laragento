<?php

namespace Laragento\SalesRule\Tests\Unit;


class SalesRuleRepositoryTest extends AbstractRepositoryTest
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function is_a_coupon_valid()
    {
        $this->initializeProduct();
        $this->initializeSalesRule();
        $this->initializeSalesRuleCoupon('AAA');
        //$this->assertTrue($this->salesRuleRepository->isCouponValid());
    }

    /**
     * @test
     */
    public function get_cart_coupon_discount_by_fixed()
    {
        $byFixedCartDiscount = 6.00;
        $salesRuleCouponCode = 'AAA';

        $this->initializeProduct();
        $this->initializeQuote();
        $this->quote->setCouponCode($salesRuleCouponCode);
        $this->initializeSalesRule(
            [
                'simple_action' => 'by_fixed',
                'discount_amount' => $byFixedCartDiscount,
            ]
        );
        $this->initializeSalesRuleCoupon($salesRuleCouponCode);

        $this->assertEquals($byFixedCartDiscount,$this->salesRuleRepository->discount($this->quote));
    }
}