<?php

namespace Laragento\Catalog\Models\Product\Super;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;


/**
 * Laragento\Catalog\Models\Product\Super\SuperLink
 *
 * @property int $link_id Link ID
 * @property int $product_id Product ID
 * @property int $parent_id Parent ID
 * @property-read \Laragento\Catalog\Models\Product\Product $parent
 * @property-read \Laragento\Catalog\Models\Product\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Super\SuperLink whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Super\SuperLink whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Super\SuperLink whereProductId($value)
 * @mixin \Eloquent
 */
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