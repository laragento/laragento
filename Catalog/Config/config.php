<?php

return [
    'name' => 'Catalog',
    'caching' => env('CACHING'),
    'pagination' => 48,
    'pagination_overview_products' => 8,
    'pagination_related_products' => 8,
    'placeholder_image_path' => env('PLACEHOLDER_IMAGE_PATH'),
    'magento_category_image_path' => env('MAGENTO_CATEGORY_IMAGE_PATH'),
];
