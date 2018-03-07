<?php

namespace Laragento\Catalog\Models\Product\Super;

use Illuminate\Database\Eloquent\Model;


/**
 * Laragento\Catalog\Models\Product\Super\SuperAttributeLabel
 *
 * @property int $value_id Value ID
 * @property int $product_super_attribute_id Product Super Attribute ID
 * @property int $store_id Store ID
 * @property int|null $use_default Use Default Value
 * @property string|null $value Value
 * @property-read \Laragento\Catalog\Models\Product\Super\SuperAttribute $superAttribute
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Super\SuperAttributeLabel whereProductSuperAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Super\SuperAttributeLabel whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Super\SuperAttributeLabel whereUseDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Super\SuperAttributeLabel whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Super\SuperAttributeLabel whereValueId($value)
 * @mixin \Eloquent
 */
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