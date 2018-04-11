<?php

namespace Laragento\Customer\Transformers;

use Laragento\Customer\Models\Customer;
use League\Fractal;

class CustomerTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = [
        'addresses',
        //'group'
    ];

    public function transform(Customer $customer)
    {
        return [
            'id' => (int)$customer->entity_id,
            'website_id' => (int)$customer->website_id,
            'email' => $customer->email,
            'group_id' => (int)$customer->group_id,
            'name' => $customer->firstname . ' ' . $customer->lastname,
            'prefix' => $customer->prefix,
            'firstname' => $customer->firstname,
            'middlename' => $customer->middlename,
            'lastname' => $customer->lastname,
            'suffix' => $customer->suffix,
            'dob' => $customer->dob,
            'gender' => $customer->gender,
            'default_billing' => $customer->default_billing,
            'default_shipping' => $customer->default_shipping,
        ];
    }

    public function includeAddresses(Customer $customer)
    {
        return $this->collection($customer->addresses, new AddressTransformer());
    }

    public function includeGroup(Customer $customer)
    {
        return $this->collection($customer->group, new GroupTransformer());
    }
}