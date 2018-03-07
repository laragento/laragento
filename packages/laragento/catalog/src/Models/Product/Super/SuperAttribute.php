<?php

namespace Laragento\Catalog\Models\Product\Super;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;
use Laragento\Eav\Models\Attribute;


/**
 * Laragento\Catalog\Models\Product\Super\SuperAttribute
 *
 * @property int $product_super_attribute_id Product Super Attribute ID
 * @property int $product_id Product ID
 * @property int $attribute_id Attribute ID
 * @property int $position Position
 * @property-read \Laragento\Eav\Models\Attribute $attribute
 * @property-read \Laragento\Catalog\Models\Product\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Super\SuperAttribute whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Super\SuperAttribute wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Super\SuperAttribute whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Super\SuperAttribute whereProductSuperAttributeId($value)
 * @mixin \Eloquent
 */
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