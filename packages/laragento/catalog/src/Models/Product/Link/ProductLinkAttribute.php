<?php

namespace Laragento\Catalog\Models\Product\Link;

use Illuminate\Database\Eloquent\Model;


/**
 * ProductLinkAttribute model
 */
class ProductLinkAttribute extends Model
{
    protected $table = 'catalog_product_link_attribute';
    protected $fillable = [
        'product_link_attribute_id',
        'link_type_id',
        'product_link_attribute_code',
        'data_type'
    ];
    protected $primaryKey = 'product_link_attribute_id';
    public $timestamps = false;

    public function linkType()
    {
        return $this->belongsTo(ProductLinkType::class, 'link_type_id');
    }

}