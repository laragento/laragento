<?php

namespace Laragento\Catalog\Models\Category;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;

/**
 * Catalog CategoryProduct model
 * @property int entity_id
 * @property int category_id
 * @property int product_id
 * @property int position
 */
class CategoryProduct extends Model
{
    protected $table = 'catalog_category_product';
    protected $fillable = [
        'entity_id',
        'category_id',
        'product_id',
        'position'
    ];
    protected $primaryKey = 'entity_id';
    public $timestamps = false;


    public function category()
    {
        return $this->hasOne(Category::class, 'entity_id', 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'entity_id', 'product_id');
    }
}