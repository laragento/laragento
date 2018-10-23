<?php

namespace Laragento\Eav\Models\Option;

use Illuminate\Database\Eloquent\Model;
use Laragento\Store\Models\Store;

/**
 * Laragento\Eav\Models\Option\AttributeOptionValue
 *
 * @property int $value_id Value Id
 * @property int $option_id Option Id
 * @property int $store_id Store Id
 * @property string|null $value Value
 * @property-read \Laragento\Eav\Models\Option\AttributeOption $option
 * @property-read \Laragento\Store\Models\Store $store
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Option\AttributeOptionValue whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Option\AttributeOptionValue whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Option\AttributeOptionValue whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Option\AttributeOptionValue whereValueId($value)
 * @mixin \Eloquent
 */
class AttributeOptionValue extends Model
{
    protected $table = 'eav_attribute_option_value';
    protected $fillable = [
        'value_id',
        'option_id',
        'store_id',
        'value',
    ];
    protected $primaryKey = 'value_id';
    public $timestamps = false;

    public function option()
    {
        return $this->hasOne(AttributeOption::class, 'option_id', 'option_id');
    }

    public function store()
    {
        return $this->hasOne(Store::class, 'store_id', 'store_id');
    }
}