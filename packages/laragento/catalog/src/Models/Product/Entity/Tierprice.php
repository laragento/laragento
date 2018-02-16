<?php

namespace Laragento\Catalog\Models\Product\Entity;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;

/**
* @package Laragento\Catalog\Models\Product\Entity
*
**/
class Tierprice extends Model
{
    protected $table = 'catalog_product_entity_tier_price';
    protected $primaryKey = 'value_id';
    protected $fillable = [
        'entity_id',
        'all_groups',
        'customer_group_id',
        'qty',
        'value',
        'website_id'
    ];
    public $timestamps = false;

    public function attribute()
    {
        return $this->hasOne(Product::class, 'entity_id', 'entity_id');
    }
}