<?php

namespace Laragento\Eav\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Attribute
 * @property int attribute_id
 * @property int entity_type_id
 * @property string attribute_code
 * @package Laragento\Eav\Models
 */
class Attribute extends Model
{
    protected $table = 'eav_attribute';
    protected $fillable = [
        'attribute_id',
        'entity_type_id',
        'attribute_code',
        'attribute_model',
        'backend_model',
        'backend_type',
        'backend_table',
        'frontend_model',
        'frontend_input',
        'frontend_label',
        'frontend_class',
        'source_model',
        'is_required',
        'is_user_defined',
        'default_value',
        'is_unique',
        'note',
    ];
    protected $primaryKey = 'attribute_id';
}