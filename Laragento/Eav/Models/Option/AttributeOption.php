<?php

namespace Laragento\Eav\Models\Option;

use Illuminate\Database\Eloquent\Model;
use Laragento\Eav\Models\Attribute;

/**
 * Laragento\Eav\Models\Option\AttributeOption
 *
 * @property int $option_id Option Id
 * @property int $attribute_id Attribute Id
 * @property int $sort_order Sort Order
 * @property-read \Laragento\Eav\Models\Attribute $attribute
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Eav\Models\Option\AttributeOptionValue[] $values
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Option\AttributeOption whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Option\AttributeOption whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Option\AttributeOption whereSortOrder($value)
 * @mixin \Eloquent
 */
class AttributeOption extends Model
{
    protected $table = 'eav_attribute_option';
    protected $fillable = [
        'option_id',
        'attribute_id',
        'sort_order',
    ];
    protected $primaryKey = 'option_id';
    public $timestamps = false;


    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'attribute_id', 'attribute_id');
    }

    public function values()
    {
        return $this->hasMany(AttributeOptionValue::class, 'option_id', 'option_id');
    }
}