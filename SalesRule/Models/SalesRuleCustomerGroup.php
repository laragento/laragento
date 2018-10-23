<?php

namespace Laragento\SalesRule\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Core\Traits\CompositePrimaryKeys;


/**
 * SalesRuleCustomerGroup model*/
class SalesRuleCustomerGroup extends Model
{
    use CompositePrimaryKeys;
    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'salesrule_customer_group';
    protected $primaryKey =
        [
            'rule_id',
            'customer_group_id',
        ];


    protected $fillable =
        [
            'rule_id',
            'customer_group_id',
        ];

    public function rule()
    {
        return $this->hasOne(SalesRule::class,'rule_id','rule_id');
    }
}