<?php

namespace Laragento\CustomerImportExport\Transformers;

use Laragento\Directory\Models\Region;
use League\Fractal;

class AddressImportTransformer extends Fractal\TransformerAbstract
{
    protected $region_id = null;
    protected $region = null;

    public function transform($address)
    {
        $this->region($address->region_code);
        return [
            'firstname' => $address->firstname,
            'middlename' => $address->middlename,
            'lastname' => $address->lastname,
            'company' => $address->company,
            'street' => $address->street,
            'city' => $address->city,
            'postcode' => (int)$address->postcode,
            'region_id' => $this->region_id,
            'region' => $this->region,
            'country_id' => $address->country_id,
            'prefix' => $address->prefix,
            'suffix' => $address->suffix,
            'telephone' => $address->telephone,
            'fax' => $address->fax,
            'default_billing' => $address->default_billing,
            'default_shipping' => $address->default_shipping,
        ];
    }

    protected function region($regionCode)
    {
        if (!$regionCode || trim($regionCode) == "") {
            return null;
        }
        $region = Region::where('code', $regionCode)->first();
        $this->region_id = $region->region_id;
        $this->region = $region->default_name;
    }

}