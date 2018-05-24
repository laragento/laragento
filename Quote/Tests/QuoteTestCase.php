<?php

namespace Laragento\Quote\Tests;

use Laragento\Customer\Repositories\CustomerRepositoryInterface;
use Tests\TestCase;

class QuoteTestCase extends TestCase
{
    protected $customerRepository;
    protected $customer;

    public function setUp()
    {
        parent::setUp();
        $this->customerRepository = $this->app->make(CustomerRepositoryInterface::class);
        $this->customer = $this->customerRepository->get()[0];
    }

    public function tearDown()
    {

        parent::tearDown();
    }
}