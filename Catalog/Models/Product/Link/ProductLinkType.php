<?php

namespace Laragento\Catalog\Models\Product\Link;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;


/**
 * ProductLink model
 *
 * @property int $link_type_id Link Type ID
 * @property string|null $code Code
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Link\ProductLinkType whereLinkTypeId($value)
 * @mixin \Eloquent
 */
class ProductLinkType extends Model
{
    protected $table = 'catalog_product_link_type';
    protected $fillable = [
        'link_type_id',
        'code'
    ];
    protected $primaryKey = 'link_type_id';
    public $timestamps = false;

}