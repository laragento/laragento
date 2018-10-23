<?php

namespace Laragento\SalesRule\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * SalesRuleCouponAggregated model*/
class SalesRuleCouponAggregated extends Model
{
    protected $table = 'salesrule_coupon_aggregated';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'period',
        'store_id',
        'order_status',
        'coupon_code',
        'coupon_uses',
        'subtotal_amount',
        'discount_amount',
        'total_amount',
        'subtotal_amount_actual',
        'discount_amount_actual',
        'total_amount_actual',
        'rule_name',
    ];
}