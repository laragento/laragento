<?php

return [
    'name' => 'Indexer',

    //which store Ids should be indexed? Default Store 0 should not be indexed, if attribute with StoreID is not found, it will fall back to default Store 0
    'stores' => [],

    //which product attributes should be indexed in DB table?
    'product_attributes' => [],

    //which category attributes should be indexed in DB table?
    'category_attributes' => []
];
