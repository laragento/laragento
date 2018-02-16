<?php

namespace Laragento\Eav\Models\Option;

use Illuminate\Database\Eloquent\Model;
use Laragento\Eav\Models\Attribute;

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