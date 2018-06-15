<?php

namespace Laragento\Catalog\Models\Category;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Category\Entity\Integer;
use Laragento\Catalog\Models\Category\Entity\Text;
use Laragento\Catalog\Models\Category\Entity\Varchar;
use Laragento\Catalog\Models\Product\Product;
use Laragento\Catalog\Models\Url\CatalogUrlRewriteProductCategory;
use Laragento\Indexer\Models\ProductIndex;

/**
 * Catalog category model
 *
 * @property int entity_id
 * @property int attribute_set_id
 * @property int parent_id
 * @property string path
 * @property int position
 * @property int level
 * @property int children_count
 * @property \Carbon\Carbon $created_at Creation Time
 * @property \Carbon\Carbon $updated_at Update Time
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Catalog\Models\Url\CatalogUrlRewriteProductCategory[] $categoryProductRewrites
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Catalog\Models\Category\Category[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Catalog\Models\Category\Entity\Integer[] $integers
 * @property-read \Laragento\Catalog\Models\Category\Category $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Catalog\Models\Product\Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Catalog\Models\Category\Entity\Text[] $texts
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Catalog\Models\Category\Entity\Varchar[] $varchars
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\Category whereAttributeSetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\Category whereChildrenCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\Category whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\Category whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\Category wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\Category wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Category\Category whereUpdatedAt($value)
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

    public function indexProducts()
    {
        return $this->belongsToMany(ProductIndex::class, 'catalog_category_product', 'category_id', 'product_id', 'entity_id', 'product_id');
    }
}