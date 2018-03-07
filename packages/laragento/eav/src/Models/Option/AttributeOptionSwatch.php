<?php

namespace Laragento\Eav\Models\Option;

use Illuminate\Database\Eloquent\Model;
use Laragento\Store\Models\Store;

/**
 * Laragento\Eav\Models\Option\AttributeOptionSwatch
 *
 * @property int $swatch_id Swatch ID
 * @property int $option_id Option ID
 * @property int $store_id Store ID
 * @property int $type Swatch type: 0 - text, 1 - visual color, 2 - visual image
 * @property string|null $value Swatch Value
 * @property-read \Laragento\Eav\Models\Option\AttributeOption $option
 * @property-read \Laragento\Store\Models\Store $store
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Option\AttributeOptionSwatch whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Option\AttributeOptionSwatch whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Option\AttributeOptionSwatch whereSwatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Option\AttributeOptionSwatch whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Option\AttributeOptionSwatch whereValue($value)
 * @mixin \Eloquent
 */
class AttributeOptionSwatch extends Model
{
    protected $table = 'eav_attribute_option_swatch';
    protected $fillable = [
        'swatch_id',
        'option_id',
        'type',
        'store_id',
        'value',
    ];
    protected $primaryKey = 'swatch_id';
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