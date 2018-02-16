<?php

namespace Laragento\Catalog\Models\Category;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Category\Entity\Integer;
use Laragento\Catalog\Models\Category\Entity\Text;
use Laragento\Catalog\Models\Category\Entity\Varchar;
use Laragento\Catalog\Models\Product\Product;
use Laragento\Catalog\Models\Url\CatalogUrlRewriteProductCategory;

/**
 * Catalog category model
 * @property int entity_id
 * @property int attribute_set_id
 * @property int parent_id
 * @property string path
 * @property int position
 * @property int level
 * @property int children_count
 */
class Category extends Model
{
    protected $table = 'catalog_category_entity';
    protected $fillable = [
        'entity_id',
        'attribute_set_id',
        'parent_id',
        'path',
        'position',
        'level',
        'children_count'
    ];
    protected $primaryKey = 'entity_id';

    public function varchars()
    {
        return $this->hasMany(Varchar::class, 'entity_id', 'entity_id');
    }

    public function integers()
    {
        return $this->hasMany(Integer::class, 'entity_id', 'entity_id');
    }

    public function texts()
    {
        return $this->hasMany(Text::class, 'entity_id', 'entity_id');
    }

    public function parent()
    {
        return $this->hasOne(Category::class, 'entity_id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'entity_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'catalog_category_product', 'category_id', 'product_id');
    }

    public function entities()
    {
        return $this->varchars()
            ->union($this->integers())
            ->union($this->texts());
    }

    public function categoryProductRewrites()
    {
        return $this->belongsToMany(CatalogUrlRewriteProductCategory::class, 'catalog_url_rewrite_product_category',
            'category_id', 'entity_id');
    }
}