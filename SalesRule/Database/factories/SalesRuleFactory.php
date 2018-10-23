<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use Laragento\SalesRule\Models\SalesRule;


/** @var \Illuminate\Database\Eloquent\Factory $factory **/
$factory->define(SalesRule::class, function (Faker $faker) {
    return [
        'name' => 'fix discount on cart',
        'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'from_date' => Carbon::now()->subMonth(),
        'to_date' => Carbon::now()->addWeeks(2),
        'uses_per_customer' => 0,
        'is_active' => 1,
        'conditions_serialized' => '{"type":"Magento\\SalesRule\\Model\\Rule\\Condition\\Combine","attribute":null,"operator":null,"value":"1","is_value_processed":null,"aggregator":"all"}',
        'actions_serialized' => '{"type":"Magento\\SalesRule\\Model\\Rule\\Condition\\Product\\Combine","attribute":null,"operator":null,"value":"1","is_value_processed":null,"aggregator":"all"}',
        'stop_rules_processing' => 0,
        'is_advanced' => 1,
        'product_ids' => '',
        'sort_order' => 0,
        'simple_action' => 'by_fixed',
        'discount_amount' => $faker->randomElement([5,10,11]),
        'discount_qty' => null,
        'discount_step' => 0,
        'apply_to_shipping' => 0,
        'times_used' => 0,
        'is_rss' => 1,
        'coupon_type' => 2,
        'use_auto_generation' => 0,
        'uses_per_coupon' => 0,
        'simple_free_shipping' => 0,
    ];
});
