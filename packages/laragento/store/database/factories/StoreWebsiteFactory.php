<?php

use Faker\Generator as Faker;

$factory->define(Laragento\Store\Models\StoreWebsite::class, function (Faker $faker) {
    $word = $faker->domainWord;
    return [
        'code' => str_slug($word),
        'name' => $word,
        'sort_order' => 0,
        'default_group_id' => 0,
        'is_default' => 1,
    ];
});
