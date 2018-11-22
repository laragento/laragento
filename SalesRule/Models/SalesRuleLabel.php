<?php

namespace Laragento\SalesRule\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * SalesRuleLabel model*/
class SalesRuleLabel extends Model
{
    protected $table = 'salesrule_label';
    protected $primaryKey = 'label_id';
    public $timestamps = false;

    protected $fillable = [
        'label_id',
        'rule_id',
        'store_id',
        'label',
    ];
}