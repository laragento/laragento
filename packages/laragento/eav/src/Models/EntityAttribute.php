<?php

namespace Laragento\Eav\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Laragento\Eav\Models\EntityAttribute
 *
 * @property int $entity_attribute_id Entity Attribute Id
 * @property int $entity_type_id Entity Type Id
 * @property int $attribute_set_id Attribute Set Id
 * @property int $attribute_group_id Attribute Group Id
 * @property int $attribute_id Attribute Id
 * @property int $sort_order Sort Order
 * @property-read \Laragento\Eav\Models\Attribute $attribute
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\EntityAttribute whereAttributeGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\EntityAttribute whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\EntityAttribute whereAttributeSetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\EntityAttribute whereEntityAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\EntityAttribute whereEntityTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\EntityAttribute whereSortOrder($value)
 * @mixin \Eloquent
 */
class EntityAttribute extends Model
{
    protected $table = 'eav_entity_attribute';
    protected $fillable = [
        'entity_attribute_id',
        'entity_type_id',
        'attribute_set_id',
        'attribute_group_id',
        'attribute_id',
        'sort_order'
    ];
    protected $primaryKey = 'entity_attribute_id';

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'attribute_id', 'attribute_id');
    }

}