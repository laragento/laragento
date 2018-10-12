<?php

namespace Laragento\SalesRule\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Core\Traits\CompositePrimaryKeys;


/**
 * SalesRuleWebsite model*/
class SalesRuleWebsite extends Model
{
    use CompositePrimaryKeys;
    public $timestamps = false;

    protected $table = 'salesrule_website';
    protected $primaryKey = ['rule_id', 'website_id'];

    protected $fillable = [
        'rule_id',
        'website_id',
    ];
}