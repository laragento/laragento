<?php

namespace Laragento\SalesRule\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Core\Traits\CompositePrimaryKeys;


/**
 * SalesRuleProductAttribute model*/
class SalesRuleProductAttribute extends Model
{
    use CompositePrimaryKeys;

    public $timestamps = false;

    protected $table = 'salesrule_product_attribute';
    protected $primaryKey =
        [
            'rule_id',
            'website_id',
            'customer_group_id',
            'attribute_id',
        ];
    protected $fillable =
        [
            'rule_id',
            'website_id',
            'customer_group_id',
            'attribute_id',
        ];
}