<?php

namespace Laragento\Indexer\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Category\Category;
use Laragento\Catalog\Models\Inventory\StockItem;
use Laragento\Catalog\Models\Product\Entity\Datetime;
use Laragento\Catalog\Models\Product\Entity\Decimal;
use Laragento\Catalog\Models\Product\Entity\Integer;
use Laragento\Catalog\Models\Product\Entity\Text;
use Laragento\Catalog\Models\Product\Entity\Tierprice;
use Laragento\Catalog\Models\Product\Entity\Varchar;

class ProductIndex extends Model
{
    protected $fillable = ['product_id', 'store_id'];

    protected $table = 'lg_catalog_product_index';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories() {
        return $this->belongsToMany(Category::class, 'catalog_category_product', 'product_id', 'category_id', 'product_id', 'entity_id');
    }


}