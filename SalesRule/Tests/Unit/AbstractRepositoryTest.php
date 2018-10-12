<?php

namespace Laragento\SalesRule\Tests\Unit;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Laragento\Catalog\Models\Product\Product;
use Laragento\Customer\Models\Customer;
use Laragento\Customer\Models\Group;
use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\SalesRule\Models\SalesRule;
use Laragento\SalesRule\Models\SalesRuleCoupon;
use Laragento\SalesRule\Repositories\SalesRuleRepository;
use Tests\CreatesApplication;
use Laragento\Quote\Tests\TestHelper;
use Faker\Generator as Faker;

abstract class AbstractRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var SalesRuleRepository
     */
    protected $salesRuleRepository;

    /**
     * @var SalesRule
     */
    protected $salesRule;

    /**
     * @var SalesRuleCoupon
     */
    protected $salesRuleCoupon;

    /**
     * @var Group
     */
    protected $customerGroup;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var QuoteSessionObject
     */
    protected $quote;

    /**
     * @var Faker
     */
    protected $faker;


    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../Database/factories');
        $this->salesRuleRepository = new SalesRuleRepository();
        //$this->faker = \Faker\Factory::create();
        DB::beginTransaction();
    }

    protected function initializeDefaultEntities()
    {
        //$this->initializeCustomerGroup();
//        $this->initializeCustomer();
//        $this->initializeProduct();
//        $this->initializeSalesRule();
//        $this->initializeSalesRuleCoupon();
    }

    protected function initializeCustomer()
    {
        $this->customer = factory(Customer::class)->create();
        return $this->customer;
    }

    protected function initializeProduct()
    {
        $this->product = factory(Product::class)->create();
        return $this->product;
    }

    protected function initializeQuote()
    {
        if(!$this->customer)
        {
            $this->initializeCustomer();
        }

        // We have a cart
        $quoteTestHelper = $this->app->make(TestHelper::class);
        $this->quote = $quoteTestHelper->createQuote();

        return $this->quote;
    }

    protected function initializeSalesRule($params = [])
    {
        $this->salesRule = factory(SalesRule::class)->create(
            $params
        );
        return $this->salesRule;
    }

    protected function initializeSalesRuleCoupon($code = false)
    {
        if(!$code)
        {
            $code = $this->faker->word;
        }
        $this->salesRuleCoupon = factory(SalesRuleCoupon::class)->create(
            [
                'rule_id' => $this->salesRule->getKey(),
                'code' => $code,
            ]
        );
        return $this->salesRuleCoupon;
    }

    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}