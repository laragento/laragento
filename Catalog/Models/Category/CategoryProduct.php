<?php

namespace Laragento\Catalog\Models\Category;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;

/**
 * Catalog CategoryProduct model
 *
 * @property int entity_id
 * @property int category_id
 * @property int product_id
 * @property int position
 * @property int $entity_id Entity ID
 * @property int $category_id Category ID
 * @property int $product_id Product ID
 * @property int $position Position
 * @property-read \Laragento\Catalog\Models\Category\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Catalog\Models\Product\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\CategoryProduct whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\CategoryProduct whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\CategoryProduct wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\CategoryProduct whereProductId($value)
 * @mixin \Eloquent
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