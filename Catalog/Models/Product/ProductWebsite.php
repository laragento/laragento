<?php

namespace Laragento\Catalog\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Inventory\Stock;

/**
 * Class ProductWebsite
 *
 * @package Laragento\Catalog\Models\Product
 * @property int product_id
 * @property int website_id
 * @property int $product_id Product ID
 * @property int $website_id Website ID
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\ProductWebsite whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\ProductWebsite whereWebsiteId($value)
 * @mixin \Eloquent
 */
class ProductWebsite extends Model
{
    protected $table = 'catalog_product_website';

    protected $fillable = [
        'product_id',
        'website_id'
    ];
    public $timestamps = false;

}