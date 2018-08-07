<?php

namespace Laragento\Quote\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuoteItem
 * @package Laragento\Quote\Models\Category
 */
class QuoteItem extends Model
{
    protected $table = 'quote_item';
    protected $fillable = [
        'item_id',
        'quote_id',
        'created_at',
        'updated_at',
        'product_id',
        'store_id',
        'is_virtual',
        'sku',
        'name',
        'description',
        'weight',
        'qty',
        'price',
        'base_price',
        'custom_price',
        'discount_percent',
        'discount_amount',
        'base_discount_amount',
        'tax_percent',
        'tax_amount',
        'base_tax_amount',
        'row_total',
        'base_row_total',
        'row_total_with_discount',
        'row_weight',
        'original_custom_price',
        'redirect_url',
        'price_incl_tax',
        'base_price_incl_tax',
        'row_total_incl_tax',
        'base_row_total_incl_tax',
        'discount_tax_compensation_amount',
        'base_discount_tax_compensation_amount',
        'free_shipping',
        'parent_item_id',
        'applied_rule_ids',
        'additional_data',
        'is_qty_decimal',
        'no_discount',
        'product_type',
        'base_tax_before_discount',
        'tax_before_discount',
        'base_cost',
        'gift_message_id',
        'weee_tax_applied',
        'weee_tax_applied_amount',
        'weee_tax_applied_row_amount',
        'weee_tax_disposition',
        'weee_tax_row_disposition',
        'base_weee_tax_applied_amount',
        'base_weee_tax_applied_row_amnt',
        'base_weee_tax_disposition',
        'base_weee_tax_row_disposition',
    ];
    protected $primaryKey = 'item_id';

    public function quote()
    {
        return $this->belongsTo(Quote::class,'quote_id','quote_id');
    }
}