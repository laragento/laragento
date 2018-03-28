<?php

namespace Laragento\Eav\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Attribute
 *
 * @property int attribute_id
 * @property int entity_type_id
 * @property string attribute_code
 * @package Laragento\Eav\Models
 * @property int $attribute_id Attribute Id
 * @property int $entity_type_id Entity Type Id
 * @property string $attribute_code Attribute Code
 * @property string|null $attribute_model Attribute Model
 * @property string|null $backend_model Backend Model
 * @property string $backend_type Backend Type
 * @property string|null $backend_table Backend Table
 * @property string|null $frontend_model Frontend Model
 * @property string|null $frontend_input Frontend Input
 * @property string|null $frontend_label Frontend Label
 * @property string|null $frontend_class Frontend Class
 * @property string|null $source_model Source Model
 * @property int $is_required Defines Is Required
 * @property int $is_user_defined Defines Is User Defined
 * @property string|null $default_value Default Value
 * @property int $is_unique Defines Is Unique
 * @property string|null $note Note
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereAttributeCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereAttributeModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereBackendModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereBackendTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereBackendType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereDefaultValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereEntityTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereFrontendClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereFrontendInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereFrontendLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereFrontendModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereIsUnique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereIsUserDefined($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Eav\Models\Attribute whereSourceModel($value)
 * @mixin \Eloquent
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