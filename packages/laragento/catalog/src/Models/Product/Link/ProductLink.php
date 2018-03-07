<?php

namespace Laragento\Catalog\Models\Product\Link;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;


/**
 * ProductLink model
 *
 * @property int $link_id Link ID
 * @property int $product_id Product ID
 * @property int $linked_product_id Linked Product ID
 * @property int $link_type_id Link Type ID
 * @property-read \Laragento\Catalog\Models\Product\Link\ProductLinkType $linkType
 * @property-read \Laragento\Catalog\Models\Product\Product $linkedProduct
 * @property-read \Laragento\Catalog\Models\Product\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLink whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLink whereLinkTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLink whereLinkedProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLink whereProductId($value)
 * @mixin \Eloquent
 */
class ProductLink extends Model
{
    protected $table = 'catalog_product_link';
    protected $fillable = [
        'link_id',
        'product_id',
        'linked_product_id',
        'link_type_id'
    ];
    protected $primaryKey = 'link_id';
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'entity_id');
    }

    public function linkedProduct()
    {
        return $this->belongsTo(Product::class, 'linked_product_id', 'entity_id');
    }

    public function linkType()
    {
        return $this->belongsTo(ProductLinkType::class, 'link_type_id');
    }
}