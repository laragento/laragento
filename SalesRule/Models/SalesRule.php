<?php

namespace Laragento\SalesRule\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * SalesRule model*/
class SalesRule extends Model
{
    const SALES_RULE_COUPON_TYPE_NO_COUPON = 1;
    const SALES_RULE_COUPON_TYPE_WITH_COUPON = 2;

    protected $table = 'salesrule';
    protected $primaryKey = 'rule_id';
    public $timestamps = false;

    protected $fillable = [
        'rule_id',
        'name',
        'description',
        'from_date',
        'to_date',
        'uses_per_customer',
        'is_active',
        'conditions_serialized',
        'actions_serialized',
        'stop_rules_processing',
        'is_advanced',
        'product_ids',
        'sort_order',
        'simple_action',
        'discount_amount',
        'discount_qty',
        'discount_step',
        'apply_to_shipping',
        'times_used',
        'is_rss',
        'coupon_type',  // 1: No Coupon 2: With coupon
        'use_auto_generation',
        'uses_per_coupon',
        'simple_free_shipping',
    ];

    public function coupons()
    {
        return $this->hasMany(SalesRuleCoupon::class, 'rule_id', 'rule_id');
    }

    public function groups()
    {
        return $this->hasMany(SalesRuleCustomerGroup::class, 'rule_id', 'rule_id');
    }
}