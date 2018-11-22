<?php

namespace Laragento\Customer\Tests\Unit;

use Laragento\Customer\Models\Address;

class AddressRepositoryTest extends AbstractRepositoryTest
{
    public function setUp()
    {
        parent::setUp();
        $this->initializeAddress();
    }

    /**
     * @test
     */
    public function get_address_by_id()
    {
        /** @var Address $address */
        $address = $this->addressRepository->first($this->address->getKey());
        $this->assertEquals($this->address->getKey(), $address->getKey());
        $this->assertEquals($this->address->firstname, $address->firstname);
        $this->assertNotNull($address->getKey());
    }

    /**
     * @test
     */
    public function store_new_address()
    {
        $addressArray = $this->address->toArray();
        $addressArray['firstname'] = (string)rand(10000000000000, 99999999999999);
        unset($addressArray['entity_id']);
        $newAddress = $this->addressRepository->store($addressArray);
        $this->assertEquals($newAddress->firstname, $addressArray['firstname']);
        $this->assertNotEquals($newAddress->firstname, $this->address->firstname);
    }

    /**
     * @test
     */
    public function get_by_customer_id()
    {
        $address = $this->addressRepository->getByCustomerId($this->address->parent_id);
        $this->assertEquals($address->first()->firstname, $this->address->firstname);
    }

    /**
     * @test
     */
    public function destroy_address()
    {
        $this->addressRepository->destroy($this->address->getKey());
        /** @var Address $address */
        $address = $this->addressRepository->first($this->address->getKey());
        $this->assertEquals(null, $address);
    }

}