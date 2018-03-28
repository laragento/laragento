<?php

use Faker\Generator as Faker;

$factory->define(Laragento\Catalog\Models\Category\Entity\Varchar::class, function (Faker $faker) {
    return [
        'store_id' => 0,
        'value' => $faker->word
    ];
});
