<?php

namespace Laragento\Catalog\Models\Product\Entity;

use Illuminate\Database\Eloquent\Model;
use Laragento\Eav\Models\Attribute;

/**
 * Catalog product entity text model
 *
 * @property int $value_id Value ID
 * @property int $attribute_id Attribute ID
 * @property int $store_id Store ID
 * @property int $entity_id Entity ID
 * @property string|null $value Value
 * @property-read \Laragento\Eav\Models\Attribute $attribute
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Text whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Text whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Text whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Text whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Text whereValueId($value)
 * @mixin \Eloquent
 */
class Text extends Model
{
    protected $table = 'catalog_product_entity_text';
    protected $fillable = ['value_id', 'attribute_id', 'store_id', 'entity_id', 'value'];
    protected $primaryKey = 'value_id';
    public $timestamps = false;

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'attribute_id', 'attribute_id');
    }
}