<?php

namespace Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Customer\Models\Customer;
use Laragento\Sales\Models\Order\Address;
use Laragento\Sales\Models\Order\Item;
use Laragento\Store\Models\Store;

/**
 * Sales Order Model
 * @property int entity_id
 * @property string state
 * @property string status
 * @property string coupon_code
 * @property string protect_code
 * @property string shipping_description
 * @property int is_virtual
 * @property int store_id
 * @property int customer_id
 * @property float base_discount_amount
 * @property float base_grand_total
 * @property float base_subtotal
 * @property float base_tax_amount
 * @property float shipping_amount
 * @property float total_qty_ordered
 * @property float customer_is_guest
 * @property int billing_address_id
 * @property int customer_group_id
 * @property int email_sent
 * @property int send_email
 * @property int shipping_address_id
 * @property string subtotal_incl_tax
 * @property string increment_id
 * @property string base_currency_code
 * @property string customer_email
 * @property string customer_firstname
 * @property string customer_lastname
 * @property string customer_middlename
 * @property string customer_prefix
 * @property string customer_suffix
 * @property string customer_taxvat
 * @property string discount_description
 * @property string order_currency_code
 * @property string original_increment_id
 * @property string shipping_method
 * @property string store_name
 * @property string customer_note
 * @property string created_at
 */
class Order extends Model
{
    protected $table = 'sales_order';
    protected $primaryKey = 'entity_id';
    protected $fillable = [
        'state',
        'status',
        'coupon_code',
        'protect_code',
        'shipping_description',
        'is_virtual',
        'store_id',
        'customer_id',
        'base_discount_amount',
        'base_grand_total',
        'base_subtotal',
        'base_tax_amount',
        'shipping_amount',
        'total_qty_ordered',
        'customer_is_guest',
        'billing_address_id',
        'customer_group_id',
        'email_sent',
        'send_email',
        'shipping_address_id',
        'subtotal_incl_tax',
        'increment_id',
        'base_currency_code',
        'customer_email',
        'customer_firstname',
        'customer_lastname',
        'customer_middlename',
        'customer_prefix',
        'customer_suffix',
        'customer_taxvat',
        'discount_description',
        'order_currency_code',
        'original_increment_id',
        'shipping_method',
        'store_name',
        'customer_note',
        'created_at',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'order_id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'parent_id', 'entity_id');
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
    public function store()
    {
        return $this->hasOne(Store::class, 'store_id', 'store_id');
    }
}