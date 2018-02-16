<?php

namespace Laragento\Catalog\Models\Product\Link;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;


/**
 * ProductLink model
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