<?php

namespace Laragento\Sales\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Laragento\Customer\Models\Customer;
use Laragento\Directory\Models\Region;
use Laragento\Sales\Models\Order;

/**
 * Sales Order Address model
 * @property int entity_id
 * @property int parent_id
 * @property int customer_address_id
 * @property int quote_address_id
 * @property int region_id
 * @property int customer_id
 * @property string fax
 * @property string region
 * @property string postcode
 * @property string lastname
 * @property string street
 * @property string city
 * @property string email
 * @property string telephone
 * @property string country_id
 * @property string firstname
 * @property string address_type
 * @property string prefix
 * @property string middlename
 * @property string suffix
 * @property string company
 * @property string vat_id
 * @property string vat_is_valid
 * @property string vat_request_id
 * @property mixed vat_request_date
 * @property int vat_request_success
 */
class Address extends Model
{
    protected $table = 'sales_order_address';
    protected $primaryKey = 'entity_id';
    protected $fillable = [
        'parent_id',
        'customer_address_id',
        'quote_address_id',
        'region_id',
        'fax',
        'region',
        'postcode',
        'lastname',
        'street',
        'city',
        'email',
        'telephone',
        'country_id',
        'firstname',
        'address_type',
        'prefix',
        'middlename',
        'suffix',
        'company',
        'vat_id',
        'vat_is_valid',
        'vat_request_id',
        'vat_request_date',
        'vat_request_success',
    ];
    protected $hidden = [
        'vat_id',
        'vat_is_valid',
        'vat_request_id',
        'vat_request_date',
        'vat_request_success',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class, 'entity_id', 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer()
    {
        return $this->hasOne(Customer::class, 'entity_id', 'customer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function region()
    {
        return $this->hasOne(Region::class, 'region_id', 'region_id');
    }
}