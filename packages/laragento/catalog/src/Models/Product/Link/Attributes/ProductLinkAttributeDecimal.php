<?php

namespace Laragento\Catalog\Models\Product\Link;

use Illuminate\Database\Eloquent\Model;


/**
 * ProductLinkAttributeDecimal model
 *
 * @property int $value_id Value ID
 * @property int|null $product_link_attribute_id Product Link Attribute ID
 * @property int $link_id Link ID
 * @property float $value Value
 * @property-read \Laragento\Catalog\Models\Product\Link\ProductLink $link
 * @property-read \Laragento\Catalog\Models\Product\Link\ProductLinkAttribute|null $productLinkAttribute
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttributeDecimal whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttributeDecimal whereProductLinkAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttributeDecimal whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkAttributeDecimal whereValueId($value)
 * @mixin \Eloquent
 */
class ProductLinkAttributeDecimal extends Model
{
    protected $table = 'catalog_product_link_attribute_decimal';
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