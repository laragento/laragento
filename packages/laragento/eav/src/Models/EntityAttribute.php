<?php

namespace Laragento\Eav\Models;

use Illuminate\Database\Eloquent\Model;

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