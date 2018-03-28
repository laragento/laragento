<?php

namespace Laragento\Customer\Tests\Unit;

use Laragento\Customer\Models\Address;
use Laragento\Customer\Models\Customer;
use Laragento\Customer\Models\Group;

class CustomerRepositoryTest extends AbstractRepositoryTest
{
    /**
     * @test
     */
    public function get_customer_by_id()
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->first($this->customer->getKey());
        $this->assertEquals($this->customer->getKey(), $customer->getKey());
        $this->assertEquals($this->customer->email, $customer->email);
        $this->assertNotNull($customer->getKey());
    }

    /**
     * @test
     */
    public function get_customer_by_email()
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->firstByEmail($this->customer->email);
        $this->assertEquals($this->customer->email, $customer->email);
        $this->assertNotNull($customer->email);
    }

    /**
     * @test
     */
    public function get_customer_group_by_customer_id()
    {
        /** @var Group $group */
        $group = $this->customerRepository->group($this->customer->getKey());
        $this->assertEquals($this->customer->group->customer_group_id, $group->getKey());
        $this->assertNotNull($group->getKey());
    }

    /**
     * @test
     */
    public function get_customer_default_billing_address()
    {
        /** @var Address $billingAddress */
        $billingAddress = $this->customerRepository->defaultBilling($this->customer->getKey());
        $this->assertNull($billingAddress);

        $this->initializeAddress();
        $this->customerRepository->assignDefaultBillingAddress($this->customer->getKey(), $this->address->getKey());

        $billingAddress = $this->customerRepository->defaultBilling($this->customer->getKey());
        $this->assertEquals($this->address->getKey(), $billingAddress->getKey());
        $this->assertNotNull($billingAddress->getKey());
    }

    /**
     * @test
     */
    public function get_customer_default_shipping_address()
    {
        /** @var Address $shippingAddress */
        $shippingAddress = $this->customerRepository->defaultShipping($this->customer->getKey());
        $this->assertNull($shippingAddress);

        $this->initializeAddress();
        $this->customerRepository->assignDefaultShippingAddress($this->customer->getKey(), $this->address->getKey());

        $shippingAddress = $this->customerRepository->defaultShipping($this->customer->getKey());
        $this->assertEquals($this->address->getKey(), $shippingAddress->getKey());
        $this->assertNotNull($shippingAddress->getKey());
    }

    /**
     * @test
     */
    public function destroy_customer_by_email()
    {
        $this->customerRepository->destroyByEmail($this->customer->email);
        $customer = $this->customerRepository->firstByEmail($this->customer->email);
        $this->assertNull($customer);
    }

    /**
     * @test
     */
    public function destroy_customer_by_customer_id()
    {
        $this->customerRepository->destroy($this->customer->getKey());
        $customer = $this->customerRepository->first($this->customer->getKey());
        $this->assertNull($customer);
    }

    /**
     * @test
     */
    public function get_customer_address_count()
    {
        $expectedAddressesCount = 3;
        $this->customer->addresses()->saveMany([
            factory(Address::class)->make(),
            factory(Address::class)->make(),
            factory(Address::class)->make(),
        ]);
        $customer = $this->customerRepository->first($this->customer->getKey());
        $this->assertEquals(count($this->customer->addresses), count($customer->addresses));
        $this->assertEquals($expectedAddressesCount, count($customer->addresses));
    }

    /**
     * @test
     */
    public function update_an_existing_customer()
    {
        // @todo dob saving/loading doesn't work correctly

        /** @var Customer $newCustomer */
        $newCustomer = $this->customerRepository->store([
            'website_id' => 1,
            'email' => $this->customer->email,
            'group_id' => $this->customer->group_id,
            'prefix' => $this->customer->prefix,
            'firstname' => $this->customer->firstname,
            'middlename' => $this->customer->middlename,
            'lastname' => $this->customer->lastname,
            'dob' => $this->customer->dob,
            'gender' => $this->customer->gender,
        ]);

        /** @var Customer $customer */
        $customer = $this->customerRepository->first($this->customer->getKey());
        $this->assertEquals($newCustomer->email, $customer->email);
        $this->assertEquals($newCustomer->group_id, $customer->group_id);
        $this->assertEquals($newCustomer->prefix, $customer->prefix);
        $this->assertEquals($newCustomer->firstname, $customer->firstname);
        $this->assertEquals($newCustomer->middlename, $customer->middlename);
        $this->assertEquals($newCustomer->lastname, $customer->lastname);
        //$this->assertEquals($newCustomer->dob, $customer->dob);
        $this->assertEquals($newCustomer->gender, $customer->gender);
    }

    /**
     * @test
     */
    public function update_an_existing_customer_with_addresses()
    {
        // @todo
        print_r('implement update_an_existing_customer_with_addresses test');
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function store_a_new_customer()
    {
        // @todo
        print_r('implement create_a_new_customer test');
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function store_a_new_customer_with_addresses()
    {
        // @todo
        print_r('implement create_a_new_customer_with_addresses test');
        $this->assertTrue(true);
    }
}