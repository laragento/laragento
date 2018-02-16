<?php

namespace Laragento\Catalog\Models\Category\Entity;

use Illuminate\Database\Eloquent\Model;
use Laragento\Eav\Models\Attribute;

/**
 * Catalog category entity text model
 */
class Text extends Model
{
    protected $table = 'catalog_category_entity_text';
    protected $fillable = ['value_id', 'attribute_id', 'store_id', 'entity_id', 'value'];
    protected $primaryKey = 'value_id';
    public $timestamps = false;

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'attribute_id', 'attribute_id');
    }
}