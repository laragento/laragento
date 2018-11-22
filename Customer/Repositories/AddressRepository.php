<?php

namespace Laragento\Customer\Repositories;

use Laragento\Customer\Models\Address;

class AddressRepository implements AddressRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function first($addressId)
    {
        return Address::whereEntityId($addressId)
            ->whereIsActive(1)
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function forceFirst($addressId)
    {
        return Address::whereEntityId($addressId)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return Address::whereIsActive(1)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return Address::get();
    }

    /**
     * {@inheritDoc}
     */
    public function find()
    {
        dd('implement find method in AddressRepository');
    }

    /**
     * {@inheritDoc}
     */
    public function store($addressData)
    {
        $address = new Address($addressData);
        $address->save();
        return $address;
    }

    /**
     * {@inheritDoc}
     */
    public function update($addressData,$addressId)
    {
        $address = $this->first($addressId);
        $address->update($addressData);
        return $address;
    }

    /**
     * {@inheritDoc}
     */
    public function destroy($addressId)
    {
        Address::destroy($addressId);
    }

    /**
     * {@inheritDoc}
     */
    public function getByCustomerId($customerId)
    {
        return Address::whereParentId($customerId)
            ->whereIsActive(1)
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function allByCustomerId($customerId)
    {
        return Address::whereParentId($customerId)->get();
    }
}