<?php

namespace Laragento\Catalog\Models\Product\Link;

use Illuminate\Database\Eloquent\Model;


/**
 * ProductLinkAttributeInteger model
 */
class ProductLinkAttributeVarchar extends Model
{
    protected $table = 'catalog_product_link_attribute_varchar';
    protected $fillable = [
        'value_id',
        'product_link_attribute_id',
        'link_id',
        'value'
    ];
    protected $primaryKey = 'value_id';
    public $timestamps = false;

    public function productLinkAttribute()
    {
        return $this->belongsTo(ProductLinkAttribute::class, 'product_link_attribute_id');
    }

    public function link()
    {
        return $this->belongsTo(ProductLink::class, 'link_id');
    }

}