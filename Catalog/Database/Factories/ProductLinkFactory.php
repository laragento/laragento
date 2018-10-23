<?php

use Faker\Generator as Faker;

$factory->define(Laragento\Catalog\Models\Product\Link\ProductLink::class, function (Faker $faker) {
    return [
        'product_id' => null,
        'linked_product_id' => null,
    ];
});

$factory->state(Laragento\Catalog\Models\Product\Link\ProductLink::class, 'up_sell', function ($faker) {
    $productLinkType = DB::table('catalog_product_link_type')->where('code','up_sell')->first();
    return [
        'link_type_id' => $productLinkType->link_type_id,
    ];
});
