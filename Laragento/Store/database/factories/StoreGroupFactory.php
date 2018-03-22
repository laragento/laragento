<?php

use Faker\Generator as Faker;

$factory->define(Laragento\Store\Models\StoreGroup::class, function (Faker $faker) {
    $word = $faker->domainWord;
    return [
        'code' => str_slug($word),
        'name' => $word,
        'root_category_id' => 0,
        'default_store_id' => 0,
    ];
});
