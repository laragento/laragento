<?php

use Faker\Generator as Faker;

$factory->define(Laragento\Catalog\Models\Category\Category::class, function (Faker $faker) {
    return [
        'attribute_set_id' => 3,
        'parent_id' => 0,
        'path' => '',
        'position' => 1,
        'level' => 1,
        'children_count' => 0,
    ];
});
