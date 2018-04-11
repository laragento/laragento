<?php

namespace Laragento\Customer\Transformers;

use Laragento\Customer\Models\Address;
use League\Fractal;

class AddressTransformer extends Fractal\TransformerAbstract
{
    public function transform(Address $address)
    {
        return [
            'id' => (int)$address->entity_id,
            'firstname' => $address->firstname,
            'middlename' => $address->middlename,
            'lastname' => $address->lastname,
            'company' => $address->company,
            'street' => $address->street,
            'city' => $address->city,
            'postcode' => (int)$address->postcode,
            'region' => $address->region,
            'region_id' => $address->region_id,
            'country_id' => $address->country_id,
            'prefix' => $address->prefix,
            'suffix' => $address->suffix,
            'telephone' => $address->telephone,
            'fax' => $address->fax,
            'short_address' => $this->getShortAddress($address),
            'default_shipping' => $this->getDefaultShipping($address),
            'default_billing' => $this->getDefaultBilling($address),
        ];
    }

    protected function getShortAddress($address)
    {
        $company = '';
        if ($address->company) {
            $company = $address->company . ', ';
        }
        return $address->firstname . ' '
            . $address->lastname . '<br/> '
            . $company
            . $address->street . '<br/> '
            . $address->postcode . ' '
            . $address->city;
    }

    protected function getDefaultShipping($address)
    {
        if ($address->customer->default_shipping) {
            return 1;
        } else {
            return 0;
        }
    }

    protected function getDefaultBilling($address)
    {
        if ($address->customer->default_billing) {
            return 1;
        } else {
            return 0;
        }
    }
}