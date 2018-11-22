<?php

use Faker\Generator as Faker;
use Laragento\SalesRule\Models\SalesRuleCustomerGroup;


/** @var \Illuminate\Database\Eloquent\Factory $factory **/
$factory->define(SalesRuleCustomerGroup::class, function (Faker $faker) {
    return [
        'rule_id' => 1,
        'customer_group_id' => 1,
    ];
});
