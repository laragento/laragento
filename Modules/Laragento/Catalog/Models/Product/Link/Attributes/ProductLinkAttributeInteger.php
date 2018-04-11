<?php

namespace Laragento\Catalog\Models\Product\Link;

use Illuminate\Database\Eloquent\Model;


/**
 * ProductLinkAttributeInteger model
 *
 * @property int $value_id Value ID
 * @property int|null $product_link_attribute_id Product Link Attribute ID
 * @property int $link_id Link ID
 * @property int $value Value
 * @property-read \Laragento\Catalog\Models\Product\Link\ProductLink $link
 * @property-read \Laragento\Catalog\Models\Product\Link\ProductLinkAttribute|null $productLinkAttribute
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttributeInteger whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttributeInteger whereProductLinkAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttributeInteger whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttributeInteger whereValueId($value)
 * @mixin \Eloquent
 */
class ProductLinkAttributeInteger extends Model
{
    protected $table = 'catalog_product_link_attribute_int';
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