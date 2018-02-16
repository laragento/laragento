<?php

namespace Laragento\Catalog\Models\Product\Super;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;
use Laragento\Eav\Models\Attribute;


class SuperAttribute extends Model
{
    protected $table = 'catalog_product_super_attribute';
    protected $fillable = [
        'product_super_attribute_id',
        'product_id',
        'attribute_id',
        'position'
    ];
    protected $primaryKey = 'product_super_attribute_id';
    public $timestamps = false;

    public function product()
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'attribute_id', 'attribute_id');
    }
}