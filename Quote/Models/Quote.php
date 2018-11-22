<?php

namespace Laragento\Quote\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Quote
 * @package Laragento\Quote\Models\Category
 */
class Quote extends Model
{
    protected $table = 'quote';
    protected $fillable = [
        'entity_id',
        'store_id',
        'created_at',
        'updated_at',
        'converted_at',
        'is_active',
        'is_virtual',
        'is_multi_shipping',
        'items_count',
        'items_qty',
        'orig_order_id',
        'store_to_base_rate',
        'store_to_quote_rate',
        'base_currency_code',
        'store_currency_code',
        'quote_currency_code',
        'grand_total',
        'base_grand_total',
        'checkout_method',
        'customer_id',
        'remote_ip',
        'customer_tax_class_id',
        'customer_group_id',
        'customer_email',
        'customer_prefix',
        'customer_firstname',
        'customer_middlename',
        'customer_lastname',
        'customer_suffix',
        'customer_dob',
        'customer_note',
        'customer_note_notify',
        'customer_is_guest',
        'remote_ip',
        'applied_rule_ids',
        'reserved_order_id',
        'password_hash',
        'coupon_code',
        'global_currency_code',
        'base_to_global_rate',
        'customer_taxvat',
        'customer_gender',
        'subtotal',
        'base_subtotal',
        'subtotal_with_discount',
        'base_subtotal_with_discount',
        'is_changed',
        'trigger_recollect',
        'ext_shipping_info',
        'is_persistent',
        'gift_message_id',
    ];
    protected $primaryKey = 'entity_id';

    public function items()
    {
        return $this->hasMany(Integer::class, 'entity_id', 'entity_id');
    }
}
