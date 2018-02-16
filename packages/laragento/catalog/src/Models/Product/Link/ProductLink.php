<?php

namespace Laragento\Catalog\Models\Product\Link;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;


/**
 * ProductLink model
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