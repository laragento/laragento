<?php

namespace Laragento\Catalog\Models\Url;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Category\Category;
use Laragento\Catalog\Models\Product\Product;

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