<?php

namespace Laragento\Customer\Tests\Unit;

use Laragento\Customer\Models\Address;
use Laragento\Customer\Models\Customer;

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
    public function get_address_by_customer_id()
    {
        /* find first address by customerId and assert address parent_id by customerId */
        $addresses = $this->addressRepository->getByCustomerId($this->customer->entity_id);
        $this->assertEquals($addresses->first()->parent_id, $this->customer->entity_id);
    }

    /**
     * @test
     */
    public function save_new_address()
    {
        $newCustomer = factory(Customer::class)->make();
        $newCustomer->save();

        $newAddress = factory(Address::class)->make([
            'parent_id' => $newCustomer->entity_id
        ]);

        $addressArray = [
            'is_active' => 1,
            'parent_id' => $newAddress->parent_id,
            'firstname' => $newAddress->firstname,
            'middlename' => $newAddress->middlename,
            'lastname' => $newAddress->lastname,
            'company' => $newAddress->company,
            'street' => $newAddress->street,
            'city' => $newAddress->city,
            'postcode' => $newAddress->postcode,
            'region_id' => $newAddress->region_id,
            'country_id' => $newAddress->country_id,
            'prefix' => $newAddress->prefix,
            'suffix' => $newAddress->suffix,
            'telephone' => $newAddress->telephone,
            'fax' => $newAddress->fax,
        ];

        $storeResponse = $this->addressRepository->store($addressArray);
        $address = $this->addressRepository->first($storeResponse->entity_id);

        /* is the store response correct? */
        $this->assertEquals($storeResponse->entity_id, $address->entity_id);

        /* is the response correct? */
        foreach ($addressArray as $addressItemKey => $addressItem) {
            $this->assertEquals($addressItem, $address->getAttribute($addressItemKey));
        }

        /* is the relation correct */
        $this->assertEquals($newCustomer->entity_id, $address->parent_id);
    }
}