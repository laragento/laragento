<?php

use Faker\Generator as Faker;

$factory->define(Laragento\Store\Models\Store::class, function (Faker $faker) {
    return [
        'code' => $faker->randomLetter.$faker->randomLetter,
        'name' => $faker->domainWord,
        'sort_order' => 0,
        'is_active' => 1,
    ];
});
