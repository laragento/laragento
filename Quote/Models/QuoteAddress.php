<?php

namespace Laragento\Quote\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuoteAddress
 * @package Laragento\Quote\Models\Category
 */
class QuoteAddress extends Model
{
    protected $table = 'quote_item';
    protected $fillable = [
        'address_id',
        'quote_id',
        'created_at',
        'updated_at',
        'customer_id',
        'save_in_address_book',
        'customer_address_id',
        'address_type',//billing,shipping
        'email',
        'prefix',
        'firstname',
        'middlename',
        'lastname',
        'suffix',
        'company',
        'street',
        'city',
        'region',
        'region_id',
        'postcode;',
        'country_id',
        'telephone',
        'fax',
        'same_as_billing',
        'collect_shipping_rates',
        'shipping_method',
        'shipping_description',
        'weight',
        'subtotal',
        'base_subtotal',
        'subtotal_with_discount',
        'base_subtotal_with_discount',
        'tax_amount',
        'base_tax_amount',
        'shipping_amount',
        'base_shipping_amount',
        'shipping_tax_amount',
        'base_shipping_tax_amount',
        'discount_amount',
        'base_discount_amount',
        'grand_total',
        'base_grand_total',
        'customer_notes',
        'applied_taxes',
        'discount_description',
        'shipping_discount_amount',
        'base_shipping_discount_amount',
        'subtotal_incl_tax',
        'base_subtotal_incl_tax',
        'discount_tax_compensation_amount',
        'base_discount_tax_compensation_amount',
        'shipping_discount_tax_compensation_amount',
        'base_shipping_discount_tax_compensation_amount',
        'shipping_incl_tax',
        'base_shipping_incl_tax',
        'free_shipping',
        'vat_id',
        'vat_is_valid',
        'vat_request_id',
        'vat_request_date',
        'vat_request_success',
        'gift_message_id',
    ];
    protected $primaryKey = 'address_id';

    public function quote()
    {
        return $this->belongsTo(Quote::class,'quote_id','quote_id');
    }
}