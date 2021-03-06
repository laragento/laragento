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

class CategoryIndex extends Model
{
    protected $fillable = ['category_id', 'store_id'];

    protected $table = 'lg_catalog_category_index';

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'entity_id');
    }
}