<?php

namespace Laragento\Catalog\Models\Product\Link;

use Illuminate\Database\Eloquent\Model;


/**
 * ProductLinkAttributeInteger model
 *
 * @property int $value_id Value ID
 * @property int $product_link_attribute_id Product Link Attribute ID
 * @property int $link_id Link ID
 * @property string|null $value Value
 * @property-read \Laragento\Catalog\Models\Product\Link\ProductLink $link
 * @property-read \Laragento\Catalog\Models\Product\Link\ProductLinkAttribute $productLinkAttribute
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttributeVarchar whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttributeVarchar whereProductLinkAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttributeVarchar whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttributeVarchar whereValueId($value)
 * @mixin \Eloquent
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