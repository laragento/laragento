<?php

namespace Laragento\SalesRule\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * SalesRuleCoupon model*/
class SalesRuleCoupon extends Model
{
    protected $table = 'salesrule_coupon';
    protected $primaryKey = 'coupon_id';
    public $timestamps = false;

    protected $fillable = [
        'coupon_id',
        'rule_id',
        'code',
        'usage_limit',
        'usage_per_customer',
        'times_used',
        'expiration_date',
        'is_primary',
        'created_at',
        'type',
        'generated_by_dotmailer',
    ];

    public function rule()
    {
        return $this->hasOne(SalesRule::class,'rule_id','rule_id');
    }
}