<?php

namespace Laragento\Catalog\Models\Url;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Category\Category;
use Laragento\Catalog\Models\Product\Product;

/**
 * Laragento\Catalog\Models\Url\CatalogUrlRewriteProductCategory
 *
 * @property int $url_rewrite_id url_rewrite_id
 * @property int $category_id category_id
 * @property int $product_id product_id
 * @property-read \Laragento\Catalog\Models\Category\Category $category
 * @property-read \Laragento\Catalog\Models\Product\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Url\CatalogUrlRewriteProductCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Url\CatalogUrlRewriteProductCategory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Url\CatalogUrlRewriteProductCategory whereUrlRewriteId($value)
 * @mixin \Eloquent
 */
class CatalogUrlRewriteProductCategory extends Model
{
    protected $table = 'catalog_url_rewrite_product_category';
    protected $fillable = [
        'url_rewrite_id',
        'category_id',
        'product_id',
    ];
    protected $primaryKey = 'url_rewrite_id';

    public function product()
    {
        return $this->hasOne(Product::class, 'product_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'category_id');
    }
}