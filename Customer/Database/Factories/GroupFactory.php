<?php

use Faker\Generator as Faker;

$factory->define(Laragento\Customer\Models\Group::class, function (Faker $faker) {
    return [
        'customer_group_id' => 0,
        'customer_group_code' => $faker->slug(1),
    ];
});
