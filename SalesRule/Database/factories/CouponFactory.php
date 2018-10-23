<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use Laragento\SalesRule\Models\SalesRule;
use Laragento\SalesRule\Models\SalesRuleCoupon;

/** @var \Illuminate\Database\Eloquent\Factory $factory **/
$factory->define(SalesRuleCoupon::class, function (Faker $faker) {
    $salesRule = factory(SalesRule::class)->create();
    return [
        //'rule_id' => $salesRule->getKey(),
        'code' => strtoupper($faker->word),
        'usage_limit' => null,
        'usage_per_customer' => null,
        'times_used' => 1,
        'expiration_date' => Carbon::now()->addWeeks(2),
        'created_at' => Carbon::now(),
        'type' => 0,
    ];
});
