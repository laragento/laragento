<?php

namespace Laragento\Customer\Repositories;

use Laragento\Customer\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function first($identifier)
    {
        if (!is_numeric($identifier)) {
            $identifier = self::getIdByEmail($identifier);
        }

        return Customer::with(['addresses', 'group'])
            ->whereEntityId($identifier)
            ->whereIsActive(1)
            //->whereStoreId(0)
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function forceFirst($identifier)
    {
        if (!is_numeric($identifier)) {
            $identifier = self::getIdByEmail($identifier);
        }
        return Customer::with(['addresses', 'group'])
            ->whereEntityId($identifier)
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return Customer::with(['addresses', 'group'])
            ->whereIsActive(1)
            ->paginate(30);
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return Customer::with(['addresses', 'group'])
            ->paginate(30);
    }

    /**
     * {@inheritDoc}
     */
    public function find()
    {
        return Customer::with(['addresses', 'group'])
            //->whereStoreId(0)
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function store($customerData)
    {
        // @todo refactor unset()
        $customer = Customer::where(['email' => $customerData['email']])->first();
        if (!$customer) {
            $customer = new Customer($customerData);
            $customer->save();
        } else {
            unset($customerData['addresses']);
            $customer->update($customerData);
            //$customer->addresses()->delete();
        }
        return $customer;
    }

    /**
     * {@inheritDoc}
     */
    public function firstByEmail($email)
    {
        return Customer::with(['addresses', 'group'])
            ->whereEmail($email)
            ->whereIsActive(1)
            //->whereStoreId(0)
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function group($customerId)
    {
        $customer = Customer::with('group')
            ->whereEntityId($customerId)
            //->whereStoreId(0)
            ->first();
        return $customer->group;
    }

    /**
     * {@inheritDoc}
     */
    public function defaultShipping($customerId)
    {
        $customer = Customer::with('shipping')
            ->whereEntityId($customerId)
            ->first();
        return $customer->shipping;
    }

    /**
     * {@inheritDoc}
     */
    public function defaultBilling($customerId)
    {
        $customer = Customer::with('billing')
            ->whereEntityId($customerId)
            ->first();
        return $customer->billing;
    }

    /**
     * {@inheritDoc}
     */
    public function assignDefaultShippingAddress($customerId,$addressId)
    {
        // @todo throw not existing exception
        // @todo throw not allowed exception
        $customer = Customer::with('shipping')
            ->whereEntityId($customerId)
            ->first();
        $customer->default_shipping = $addressId;
        $customer->save();
        return $customer;
    }

    /**
     * {@inheritDoc}
     */
    public function assignDefaultBillingAddress($customerId,$addressId)
    {
        // @todo throw not existing exception
        // @todo throw not allowed exception
        $customer = Customer::with('billing')
            ->whereEntityId($customerId)
            ->first();
        $customer->default_billing = $addressId;
        $customer->save();
        return $customer;
    }

    /**
     * {@inheritDoc}
     */
    public function destroy($customerId)
    {
        Customer::whereEntityId($customerId)->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function destroyByEmail($email)
    {
        Customer::whereEmail($email)->delete();
    }

    /**
     * {@inheritDoc}
     */
    public static function getIdByEmail($email)
    {
        return Customer::whereEmail($email)
            ->first()
            ->entity_id;
    }
}