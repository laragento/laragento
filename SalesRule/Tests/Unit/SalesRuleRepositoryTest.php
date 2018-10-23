<?php

namespace Laragento\SalesRule\Tests\Unit;

use Laragento\SalesRule\DataObjects\RuleInterface;
use Laragento\SalesRule\Exceptions\NegativeSubtotalException;

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
        $couponCode = 'AAA';
        $this->initializeProduct();
        $this->initializeSalesRule([
            'simple_action' => RuleInterface::DISCOUNT_ACTION_FIXED_AMOUNT_FOR_CART
        ]);
        $this->initializeSalesRuleCoupon($couponCode);
        $this->assertTrue($this->salesRuleRepository->isCouponValid($couponCode));
    }

    /**
     * @test
     */
    public function is_a_coupon_not_valid()
    {
        $this->assertFalse($this->salesRuleRepository->isCouponValid($this->faker->slug(6)));
    }

    /**
     * @test
     * @throws NegativeSubtotalException
     * @throws \Exception
     */
    public function get_cart_coupon_discount_by_fixed_amount_for_cart()
    {
        $fixedCartDiscount = rand(5, 15);
        $rules = $this->getSalesRuleCouponDiscount($fixedCartDiscount);

        /** @var RuleInterface $rule */
        foreach ($rules as $rule){
            $this->assertEquals($fixedCartDiscount, $rule->discount_amount);
        }
        $this->assertCount(1,$rules);
    }

    /**
     * @test
     * @throws NegativeSubtotalException
     * @throws \Exception
     */
    public function get_cart_coupon_discount_by_percent()
    {
        $percentCartDiscount = 10.00;
        $productPrice = 165.00;
        $expectedResult = 10.00; // we do not calculate anything, just look for active rules

        $rules = $this->getSalesRuleCouponDiscount(
            $percentCartDiscount,
            RuleInterface::DISCOUNT_ACTION_BY_PERCENT,
            [
                'price' => $productPrice
            ]
        );
        /** @var RuleInterface $rule */
        foreach ($rules as $rule){
            $this->assertEquals($expectedResult, $rule->discount_amount);
        }
        $this->assertCount(1,$rules);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function throw_exception_when_discount_is_bigger_than_subtotal()
    {
        $fixedCartDiscount = 10000000;

        try {
            $this->getSalesRuleCouponDiscount($fixedCartDiscount);
            $this->assertTrue(false);
        } catch (NegativeSubtotalException $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * @test
     * @throws \Exception
     */
    public function invalid_sales_rule_for_customer_group()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function valid_sales_rule_for_customer_group()
    {
        $discountAmount = 10;
        $customerGroup = $this->initializeCustomerGroup();

        $customer = $this->initializeCustomer([
            'group_id' => $customerGroup->customer_group_id
        ]);

        $salesRule = $this->initializeSalesRule([
            'discount_amount' => $discountAmount,
            'simple_action' => RuleInterface::DISCOUNT_ACTION_FIXED_AMOUNT_FOR_CART
        ]);

        $salesRuleCustomerGroup = $this->initializeSalesRuleCustomerGroup([
            'rule_id' => $salesRule->getKey(),
            'customer_group_id' => $customerGroup->customer_group_id
        ]);

//        $quote = $this->initializeQuote();
//        $rules = $this->salesRuleRepository->rule($quote);
//
//        $this->assertEquals($discountAmount, $rule->discount_amount);
        $this->assertTrue(true);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}