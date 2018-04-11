<?php

namespace Laragento\Catalog\Models\Product\Entity;

use Illuminate\Database\Eloquent\Model;
use Laragento\Eav\Models\Attribute;


/**
 * Laragento\Catalog\Models\Product\Entity\Gallery
 *
 * @property int $value_id Value ID
 * @property int $attribute_id Attribute ID
 * @property int $store_id Store ID
 * @property int $entity_id Entity ID
 * @property int $position Position
 * @property string|null $value Value
 * @property-read \Laragento\Eav\Models\Attribute $attribute
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Gallery whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Gallery whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Gallery wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Gallery whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Gallery whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Gallery whereValueId($value)
 * @mixin \Eloquent
 */
class Gallery extends Model
{
    protected $table = 'catalog_product_entity_gallery';
    protected $fillable = [
        'value_id',
        'attribute_id',
        'store_id',
        'entity_id',
        'position',
        'value'
    ];
    protected $primaryKey = 'value_id';
    public $timestamps = false;

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'attribute_id', 'attribute_id');
    }
}