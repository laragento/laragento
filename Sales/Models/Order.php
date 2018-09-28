<?php

namespace Laragento\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Customer\Models\Customer;
use Laragento\Sales\Models\Order\Address;
use Laragento\Sales\Models\Order\Item;
use Laragento\Sales\Models\Order\Payment;
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
* @property float base_discount_canceled
* @property float base_discount_invoiced
* @property float base_discount_refunded
* @property float base_grand_total
* @property float base_shipping_amount
* @property float base_shipping_canceled
* @property float base_shipping_invoiced
* @property float base_shipping_refunded
* @property float base_shipping_tax_amount
* @property float base_shipping_tax_refunded
* @property float base_subtotal
* @property float base_subtotal_canceled
* @property float base_subtotal_invoiced
* @property float base_subtotal_refunded
* @property float base_tax_amount
* @property float base_tax_canceled
* @property float base_tax_invoiced
* @property float base_tax_refunded
* @property float base_to_global_rate
* @property float base_to_order_rate
* @property float base_total_canceled
* @property float base_total_invoiced
* @property float base_total_invoiced_cost
* @property float base_total_offline_refunded
* @property float base_total_online_refunded
* @property float base_total_paid
* @property float base_total_qty_ordered
* @property float base_total_refunded
* @property float discount_amount
* @property float discount_canceled
* @property float discount_invoiced
* @property float discount_refunded
* @property float grand_total
* @property float shipping_amount
* @property float shipping_canceled
* @property float shipping_invoiced
* @property float shipping_refunded
* @property float shipping_tax_amount
* @property float shipping_tax_refunded
* @property float store_to_base_rate
* @property float store_to_order_rate
* @property float subtotal
* @property float subtotal_canceled
* @property float subtotal_invoiced
* @property float subtotal_refunded
* @property float tax_amount
* @property float tax_canceled
* @property float tax_invoiced
* @property float tax_refunded
* @property float total_canceled
* @property float total_invoiced
* @property float total_offline_refunded
* @property float total_online_refunded
* @property float total_paid
* @property float total_qty_ordered
* @property float total_refunded
* @property int can_ship_partially
* @property int can_ship_partially_item
* @property int customer_is_guest
* @property int customer_note_notify
* @property int billing_address_id
* @property int customer_group_id
* @property int edit_increment
* @property int email_sent
* @property int send_email
* @property int forced_shipment_with_invoice
* @property int payment_auth_expiration
* @property int quote_address_id
* @property int quote_id
* @property int shipping_address_id
* @property float adjustment_negative
* @property float adjustment_positive
* @property float base_adjustment_negative
* @property float base_adjustment_positive
* @property float base_shipping_discount_amount
* @property float base_subtotal_incl_tax
* @property float base_total_due
* @property float payment_authorization_amount
* @property float shipping_discount_amount
* @property float subtotal_incl_tax
* @property float total_due
* @property float weight
* @property mixed customer_dob
* @property string increment_id
* @property string applied_rule_ids
* @property string base_currency_code
* @property string customer_email
* @property string customer_firstname
* @property string customer_lastname
* @property string customer_middlename
* @property string customer_prefix
* @property string customer_suffix
* @property string customer_taxvat
* @property string discount_description
* @property string ext_customer_id
* @property string ext_order_id
* @property string global_currency_code
* @property string hold_before_state
* @property string hold_before_status
* @property string order_currency_code
* @property string original_increment_id
* @property string relation_child_id
* @property string relation_child_real_id
* @property string relation_parent_id
* @property string relation_parent_real_id
* @property string remote_ip
* @property string shipping_method
* @property string store_currency_code
* @property string store_name
* @property string x_forwarded_for
* @property string customer_note
* @property mixed created_at
* @property mixed updated_at
* @property int total_item_count
* @property int customer_gender
* @property float discount_tax_compensation_amount
* @property float base_discount_tax_compensation_amount
* @property float shipping_discount_tax_compensation_amount
* @property float base_shipping_discount_tax_compensation_amnt
* @property float discount_tax_compensation_invoiced
* @property float base_discount_tax_compensation_invoiced
* @property float discount_tax_compensation_refunded
* @property float base_discount_tax_compensation_refunded
* @property float shipping_incl_tax
* @property float base_shipping_incl_tax
* @property string coupon_rule_name
* @property int gift_message_id
* @property int paypal_ipn_customer_notified
 *
 */
class Order extends Model
{
    protected $table = 'sales_order';
    protected $primaryKey = 'entity_id';
    protected $guarded = [];


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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class,'parent_id', 'entity_id');
    }
}