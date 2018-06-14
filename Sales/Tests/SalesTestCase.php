<?php

namespace Laragento\Sales\Tests;

use Laragento\Customer\Repositories\CustomerRepositoryInterface;
use Laragento\Quote\DataObject\QuoteSessionObject;
use Laragento\Quote\Managers\QuoteItemManager;
use Laragento\Quote\Repositories\QuoteSessionItemRepositoryInterface;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;
use Laragento\Sales\Managers\OrderManager;
use Tests\TestCase;

/**
 * Class SalesTestCase
 * @package Laragento\Sales\Tests
 */
abstract class SalesTestCase extends TestCase
{
    /**
     * @var QuoteSessionObjectRepositoryInterface
     */
    protected $quoteDataRepository;
    /**
     * @var QuoteSessionItemRepositoryInterface
     */
    protected $quoteItemRepository;
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;
    /**
     * @var
     */
    protected $customer;
    /**
     * @var QuoteItemManager
     */
    protected $itemManager;
    /**
     * @var OrderManager
     */
    protected $orderManager;


    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->customerRepository = $this->app->make(CustomerRepositoryInterface::class);
        $this->quoteDataRepository = $this->app->make(QuoteSessionObjectRepositoryInterface::class);
        $this->quoteItemRepository = $this->app->make(QuoteSessionItemRepositoryInterface::class);
        $this->itemManager = $this->app->make(QuoteItemManager::class);
        $this->orderManager = $this->app->make(OrderManager::class);

        $this->customer = $this->customerRepository->get()[0];

        $this->createQuote();
        $this->populateCart();
    }


    /**
     *
     */
    protected function populateCart()
    {
        $data = ['sku' => '003222', 'qty' => 10];
        $this->itemManager->storeItems($data);
    }

    /**
     *
     */
    protected function createQuote()
    {
        $this->actingAs($this->customer);
        $this->quoteDataRepository->createQuote();
    }

    /**
     * @return QuoteSessionObject|mixed
     */
    protected function quote()
    {
        return $this->quoteDataRepository->getQuote();
    }

    /**
     * @return array
     */
    protected function quoteItems()
    {
        return $this->quoteDataRepository->getQuote()->getItems();
    }

    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }


}
