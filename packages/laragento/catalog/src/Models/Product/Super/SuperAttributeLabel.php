<?php

namespace Laragento\Catalog\Models\Product\Super;

use Illuminate\Database\Eloquent\Model;


class SuperAttributeLabel extends Model
{
    protected $table = 'catalog_product_super_attribute_label';
    protected $fillable = [
        'value_id',
        'product_super_attribute_id',
        'store_id',
        'use_default',
        'value',
    ];
    protected $primaryKey = 'value_id';
    public $timestamps = false;


    public function superAttribute()
    {
        return $this->hasOne(SuperAttribute::class, 'product_super_attribute_id', 'product_super_attribute_id');
    }
}