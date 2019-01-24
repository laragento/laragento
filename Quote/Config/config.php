<?php

return [
    'name' => 'Quote',
    'totals' => [
        'tax_percent' => '7.7000'   // @todo make this more dynamic (Every product has its own tax-class)
    ],
    'tax_calculation_price_includes_tax' => true,
    // Are catalog prices in admin panel already with tax included?
    'tax_calculation_shipping_includes_tax' => true,
    // Are shipping costs and gateways in admin panel with tax included?
    'tax_display_type' => 2,
    // 1. Excl. Tax 2. Incl. Tax 3. Incl. and Excl. Tax
    'tax_display_shipping' => 2,
    // 1. Excl. Tax 2. Incl. Tax 3. Incl. and Excl. Tax
    'calculateTotals' => true,
    'use_item_description_in_quote' => true,
    'max_qty_per_item' => 10,
    'min_cart_subtotal' => 5.00,
    'free_shipping_threshold' => 50.00,
    'shipping_providers' =>
        [

        ],
    'payment_providers' =>
        [

        ]
];