<?php

namespace Laragento\Customer\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Directory\Models\Region;

/**
 * Customer Address model
 *
 * @property int entity_id
 * @property int increment_id
 * @property int parent_id
 * @property int is_active
 * @property string city
 * @property string company
 * @property int country_id
 * @property string fax
 * @property string firstname
 * @property string lastname
 * @property string middlename
 * @property int postcode
 * @property string prefix
 * @property string region
 * @property mixed region_id
 * @property string street
 * @property string suffix
 * @property string telephone
 * @property int vat_id
 * @property int vat_is_valid
 * @property mixed vat_request_date
 * @property int vat_request_id
 * @property int vat_request_success
 * @property-read \Laragento\Customer\Models\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereIncrementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereVatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereVatIsValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereVatRequestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereVatRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Address whereVatRequestSuccess($value)
 * @mixin \Eloquent
 */
class Address extends Model
{
    protected $table = 'customer_address_entity';
    protected $primaryKey = 'entity_id';
    protected $fillable = [
        'entity_id',
        'increment_id',
        'parent_id',
        'is_active',
        'city',
        'company',
        'country_id',
        'fax',
        'firstname',
        'lastname',
        'middlename',
        'postcode',
        'prefix',
        'region',
        'region_id',
        'street',
        'suffix',
        'telephone',
        'vat_id',
        'vat_is_valid',
        'vat_request_date',
        'vat_request_id',
        'vat_request_success',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'vat_id',
        'vat_is_valid',
        'vat_request_date',
        'vat_request_id',
        'vat_request_success',
    ];
    protected $defaultBilling = 0;
    protected $defaultShipping = 0;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer()
    {
        return $this->hasOne(Customer::class, 'entity_id', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function region()
    {
        return $this->hasOne(Region::class, 'region_id', 'region_id');
    }

    /**
     * @return int
     */
    public function getDefaultBilling(): int
    {
        return $this->defaultBilling;
    }

    /**
     * @param int $defaultBilling
     */
    public function setDefaultBilling(int $defaultBilling)
    {
        $this->defaultBilling = $defaultBilling;
    }

    /**
     * @return int
     */
    public function getDefaultShipping(): int
    {
        return $this->defaultShipping;
    }

    /**
     * @param int $defaultShipping
     */
    public function setDefaultShipping(int $defaultShipping)
    {
        $this->defaultShipping = $defaultShipping;
    }


}