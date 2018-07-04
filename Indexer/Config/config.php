<?php

return [
    'name' => 'Indexer',

    //which store Ids should be indexed? Default Store 0 should not be indexed, if attribute with StoreID is not found, it will fall back to default Store 0
    'stores' => [],

    //filter products who should be imported to index table
    'product_filter' => '',
    //filter categories who should be imported to index table
    'category_filter' => '',

    //which product attributes should be indexed in DB table?
    'product_attributes' => [],

    //which category attributes should be indexed in DB table?
    'category_attributes' => []
];
