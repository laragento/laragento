<?php

use Faker\Generator as Faker;

$factory->define(Laragento\Catalog\Models\Product\Product::class, function (Faker $faker) {
    return [
//        'attribute_set_id' => $fa, // @todo get correct from eav_entity_type and eav_attribute_set
//        'type_id' => 'simple', // @todo add grouped, bundle..
//        'has_options' => 0, // @todo add 1
//        'required_options' => 0, // todo add 1
        'sku' => $faker->unique()->slug,

    ];
});
