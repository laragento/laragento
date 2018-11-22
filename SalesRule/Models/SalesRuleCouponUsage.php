<?php

namespace Laragento\SalesRule\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Core\Traits\CompositePrimaryKeys;


/**
 * SalesRuleCouponUsage model*/
class SalesRuleCouponUsage extends Model
{
    use CompositePrimaryKeys;
    public $timestamps = false;

    protected $table = 'salesrule_coupon_usage';
    protected $primaryKey =
        [
            'coupon_id',
            'customer_id',
        ];

    protected $fillable =
        [
            'coupon_id',
            'customer_id',
            'times_used',
        ];
}