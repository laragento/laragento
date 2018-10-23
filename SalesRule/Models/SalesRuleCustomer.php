<?php

namespace Laragento\SalesRule\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * SalesRuleCustomer model*/
class SalesRuleCustomer extends Model
{
    protected $table = 'salesrule_customer';
    protected $primaryKey = 'rule_customer_id';
    public $timestamps = false;

    protected $fillable = [
        'rule_customer_id',
        'rule_id',
        'customer_id',
        'times_used',
    ];
}