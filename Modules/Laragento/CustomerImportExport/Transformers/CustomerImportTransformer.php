<?php

namespace Laragento\CustomerImportExport\Transformers;

use League\Fractal;

class CustomerImportTransformer extends Fractal\TransformerAbstract
{
    /**
     * @param \stdClass $customer
     * @return array
     */
    public function transform(\stdClass $customer)
    {
        return [
            'website_id' => $customer->website_id,
            'email' => $customer->email,
            'taxvat' => $customer->taxvat,
            'group_id' => $customer->group_id,
            'increment_id' => null,
            'store_id' => $customer->store_id,
            'is_active' => $customer->is_active,
            'prefix' => $customer->prefix,
            'firstname' => $customer->firstname,
            'middlename' => $customer->middlename,
            'lastname' => $customer->lastname,
            'suffix' => $customer->suffix,
            'dob' => $customer->dob,
            'gender' => $customer->gender
        ];
    }
}