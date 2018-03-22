<?php

namespace Laragento\Customer\Tests\Unit;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Laragento\Customer\Models\Address;
use Laragento\Customer\Repositories\AddressRepository;
use Laragento\Customer\Repositories\CustomerRepository;
use Tests\CreatesApplication;
use Laragento\Customer\Models\Customer;

abstract class AbstractRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var AddressRepository
     */
    protected $addressRepository;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var Address
     */
    protected $address;


    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');
        $this->addressRepository = new AddressRepository();
        $this->customerRepository = new CustomerRepository();

        DB::beginTransaction();

        $this->initializeCustomer();
    }

    protected function initializeCustomer()
    {
        /* create new customer */
        $this->customer = factory(Customer::class)->make();
        $this->customer->save();
    }

    protected function initializeAddress()
    {
        /* assign new address to customer */
        $this->address = factory(Address::class)->make([
            'parent_id' => $this->customer->entity_id
        ]);
        $this->address->save();
    }

    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}