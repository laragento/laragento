<?php

namespace Laragento\Catalog\Models\Product\Super;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;


class SuperLink extends Model
{
    protected $table = 'catalog_product_super_link';
    protected $fillable = [
        'link_id',
        'product_id',
        'parent_id',
    ];
    protected $primaryKey = 'link_id';
    public $timestamps = false;


    public function product()
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }

    public function parent()
    {
        return $this->hasOne(Product::class, 'link_id', 'parent_id');
    }
}