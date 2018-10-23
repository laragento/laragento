<?php

namespace Laragento\SalesRule\Tests\Unit;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Laragento\Catalog\Models\Product\Product;
use Laragento\Catalog\Repositories\Product\ProductRepository;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;
use Laragento\Customer\Models\Customer;
use Laragento\Customer\Models\Group;
use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\Tests\QuoteTestHelper;
use Laragento\SalesRule\DataObjects\Rule;
use Laragento\SalesRule\DataObjects\RuleInterface;
use Laragento\SalesRule\Exceptions\NegativeSubtotalException;
use Laragento\SalesRule\Models\SalesRule;
use Laragento\SalesRule\Models\SalesRuleCoupon;
use Laragento\SalesRule\Models\SalesRuleCustomer;
use Laragento\SalesRule\Models\SalesRuleCustomerGroup;
use Laragento\SalesRule\Repositories\SalesRuleRepository;
use Tests\CreatesApplication;
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

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var
     */
    protected $productAttributeRepository;


    public function setUp()
    {
        parent::setUp();

        $this->app->bind('Laragento\SalesRule\DataObjects\RuleInterface',
            'Laragento\SalesRule\DataObjects\Rule');

        $this->faker = $this->app->make('Faker\Generator');
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../Database/factories');
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../../Customer/Database/factories');
        $this->productRepository = $this->app->make('Laragento\Catalog\Repositories\Product\ProductRepository');
        $this->productAttributeRepository = $this->app->make('Laragento\Catalog\Repositories\Product\ProductAttributeRepository');
        $this->salesRuleRepository = $this->app->make('Laragento\SalesRule\Repositories\SalesRuleRepository');

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

    /**
     * @param array $params
     * @return Customer
     */
    protected function initializeCustomer($params = []): Customer
    {
        $this->customer = factory(Customer::class)->create(
            $params
        );
        return $this->customer;
    }

    /**
     * @param array $params
     * @return Group
     */
    protected function initializeCustomerGroup($params = []): Group
    {
        $this->customerGroup = factory(Group::class)->create(
            $params
        );
        return $this->customerGroup;
    }


    /**
     * @param null $productConfig
     * @return Product
     */
    protected function initializeProduct($productConfig = null): Product
    {
//        $eavEntityType = DB::table('eav_entity_type')->where('entity_type_code', 'catalog_product')->first();
//        $eavAttributeSet = DB::table('eav_attribute_set')->where('entity_type_id',
//        $eavEntityType->entity_type_id)->first();
        $price = $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 2000);

        if($productConfig != null){
            if(isset($productConfig['price'])){
                $price = (float)$productConfig['price'];
            }
        }
        $data = [
            'sku' => str_slug(str_random(10)),
            'website_id' => 1,
            'store_id' => 0,
            'type_id' => 'simple',
            'status' => 1,
            'product_online' => 1,
            'position' => 1,
            'weight' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 2000),
            'price' => $price,
            //'tier_prices' => $this->currentTierPrices,
            //'special_price' => $this->price((string)$simple->special_price),
            //'special_from_date' => $this->specialDate((string)$simple->special_from_date),
            //'special_to_date' => $this->specialDate((string)$simple->special_to_date),
            'qty' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'max_sale_qty' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'tax' => (double)7.7,
            'url_key' => substr($this->faker->unique()->slug, 0, 20),
            'name' => (string)$this->faker->sentence($nbWords = 3, $variableNbWords = false),
            'meta_title' => (string)$this->faker->sentence($nbWords = 3, $variableNbWords = false),
            'meta_description' => '',
            'meta_keyword' => '',
            'country_of_manufacture' => 'CH',
            'visibility' => ProductRepositoryInterface::VISIBILITY_NOT_VISIBLE_INDIVIDUALLY,
            'quantity_and_stock_status' => 1,
            'gift_message_available' => 2,
            'color' => 1,
            'options_container' => "container2",
        ];
        $this->product = $this->productRepository->store($data);

//        $attr = $this->productAttributeRepository->data('price',
//            $this->product->getKey(), $storeId = 0);

        //$this->product = factory(Product::class)->states('simple')->create();
        return $this->product;
    }

    /**
     * @param null $productConfig
     * @return QuoteSessionObject
     * @throws \Exception
     */
    protected function initializeQuote($productConfig = null): QuoteSessionObject
    {
        if (!$this->customer) {
            $this->initializeCustomer();
        }

        if (!$this->product) {
            $this->initializeProduct($productConfig);
        }

        $products[] = $this->product;

        // We have a cart
        /** @var QuoteTestHelper $quoteTestHelper */
        $quoteTestHelper = $this->app->make(QuoteTestHelper::class);
        $this->quote = $quoteTestHelper->create($products);

        return $this->quote;
    }

    /**
     * @param array $params
     * @return SalesRule|mixed
     */
    protected function initializeSalesRule($params = [])
    {
        $this->salesRule = factory(SalesRule::class)->create(
            $params
        );
        return $this->salesRule;
    }


    /**
     * @param array $params
     * @return SalesRule|mixed
     */
    protected function initializeSalesRuleCustomerGroup($params = [])
    {
        $this->customerGroup = factory(SalesRuleCustomerGroup::class)->create(
            $params
        );
        return $this->customerGroup;
    }


    /**
     * @param bool $code
     * @return SalesRuleCoupon|mixed
     */
    protected function initializeSalesRuleCoupon($code = false)
    {
        if (!$code) {
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

    /**
     * @param $fixedCartDiscount
     * @param string $simpleAction
     * @param null $productConfig
     * @return RuleInterface[]
     * @throws NegativeSubtotalException
     * @throws \Exception
     */
    protected function getSalesRuleCouponDiscount(
        $fixedCartDiscount,
        $simpleAction = RuleInterface::DISCOUNT_ACTION_FIXED_AMOUNT_FOR_CART,
        $productConfig = null
    ) {
        $salesRuleCouponCode = str_slug(str_random(6));

        $this->initializeQuote($productConfig);

        $this->quote->setCouponCode($salesRuleCouponCode);
        $this->initializeSalesRule(
            [
                'simple_action' => $simpleAction,
                'discount_amount' => $fixedCartDiscount,
            ]
        );
        $this->initializeSalesRuleCoupon($salesRuleCouponCode);

        return $this->salesRuleRepository->rules($this->quote);
    }

    /**
     *
     */
    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }

}