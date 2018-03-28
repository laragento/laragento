<?php

namespace Laragento\Catalog\Models\Product\Link;

use Illuminate\Database\Eloquent\Model;


/**
 * ProductLinkAttribute model
 *
 * @property int $product_link_attribute_id Product Link Attribute ID
 * @property int $link_type_id Link Type ID
 * @property string|null $product_link_attribute_code Product Link Attribute Code
 * @property string|null $data_type Data Type
 * @property-read \Laragento\Catalog\Models\Product\Link\ProductLinkType $linkType
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttribute whereDataType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttribute whereLinkTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttribute whereProductLinkAttributeCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttribute whereProductLinkAttributeId($value)
 * @mixin \Eloquent
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