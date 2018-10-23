<?php

return [
    'name' => 'Quote',
    'totals' => [
        'tax_percent' => '7.7000'   // @todo make this more dynamic (Every product has its own tax-class)
    ],
    'tax_calculation_price_includes_tax' => true,   // Are catalog prices in admin panel already with tax included?
    'tax_calculation_shipping_includes_tax' => true, // Are shipping costs and gateways in admin panel with tax included?
    'tax_display_type' => 1, // 1. Excl. Tax 2. Incl. Tax 3. Incl. and Excl. Tax
    'tax_display_shipping' => 1, // 1. Excl. Tax 2. Incl. Tax 3. Incl. and Excl. Tax
    'calculateTotals' => true,
    'shipping_providers' =>
    [

    ],
    'payment_providers' =>
    [

    ],
];
