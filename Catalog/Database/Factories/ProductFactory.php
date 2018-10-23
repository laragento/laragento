<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Laragento\Catalog\Models\Product\Product::class, function (Faker $faker) {
    $eavEntityType = DB::table('eav_entity_type')->where('entity_type_code','catalog_product')->first();
    $eavAttributeSet = DB::table('eav_attribute_set')->where('entity_type_id',$eavEntityType->entity_type_id)->first();
    return [
        'sku' => substr($faker->unique()->slug,0,20),
        'type_id' => 'simple',
        'has_options' => 0,
        'required_options' => 0,
        'attribute_set_id' => $eavAttributeSet->attribute_set_id,
    ];
});

$factory->state(Laragento\Catalog\Models\Product\Product::class, 'simple', function ($faker) {
    return [
        'type_id' => 'simple',
    ];
});
