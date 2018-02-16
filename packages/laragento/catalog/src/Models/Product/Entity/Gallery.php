<?php

namespace Laragento\Catalog\Models\Product\Entity;

use Illuminate\Database\Eloquent\Model;
use Laragento\Eav\Models\Attribute;


class Gallery extends Model
{
    protected $table = 'catalog_product_entity_gallery';
    protected $fillable = [
        'value_id',
        'attribute_id',
        'store_id',
        'entity_id',
        'position',
        'value'
    ];
    protected $primaryKey = 'value_id';
    public $timestamps = false;

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'attribute_id', 'attribute_id');
    }
}