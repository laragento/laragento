<?php

namespace Laragento\Catalog\Models\Product\Entity;

use Illuminate\Database\Eloquent\Model;
use Laragento\Eav\Models\Attribute;

/**
 * Class Datetime
 * @package App\Modules\Laragento\Catalog\Model\Product\Eloquent\Entity
 */
class Datetime extends Model
{
    protected $table = 'catalog_product_entity_datetime';
    protected $fillable = ['value_id', 'attribute_id', 'store_id', 'entity_id', 'value'];
    protected $primaryKey = 'value_id';
    public $timestamps = false;

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'attribute_id', 'attribute_id');
    }
}