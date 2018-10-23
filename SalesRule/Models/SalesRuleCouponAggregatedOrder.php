<?php

namespace Laragento\SalesRule\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * SalesRuleCouponAggregatedOrder model*/
class SalesRuleCouponAggregatedOrder extends Model
{
    protected $table = 'salesrule_coupon_aggregated_order';
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
        'rule_name',
    ];
}