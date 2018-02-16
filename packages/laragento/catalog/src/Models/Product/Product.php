<?php

namespace Laragento\Catalog\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Category\Category;
use Laragento\Catalog\Models\Product\Entity\Datetime;
use Laragento\Catalog\Models\Product\Entity\Decimal;
use Laragento\Catalog\Models\Product\Entity\Integer;
use Laragento\Catalog\Models\Product\Entity\Text;
use Laragento\Catalog\Models\Product\Entity\Tierprice;
use Laragento\Catalog\Models\Product\Entity\Varchar;

/**
 * Product product model
 * @property int entity_id
 * @property int attribute_set_id
 * @property string type_id
 * @property string sku
 * @property int has_options
 * @property mixed required_options
 */
class Product extends Model
{
    protected $table = 'catalog_product_entity';
    protected $fillable = [
        'entity_id',
        'attribute_set_id',
        'type_id',
        'sku',
        'has_options',
        'required_options'
    ];
    protected $primaryKey = 'entity_id';

    public function texts()
    {
        return $this->hasMany(Text::class, 'entity_id', 'entity_id');
    }

    public function varchars()
    {
        return $this->hasMany(Varchar::class, 'entity_id', 'entity_id');
    }

    public function decimals()
    {
        return $this->hasMany(Decimal::class, 'entity_id', 'entity_id');
    }

    public function integers()
    {
        return $this->hasMany(Integer::class, 'entity_id', 'entity_id');
    }

    public function datetimes()
    {
        return $this->hasMany(Datetime::class, 'entity_id', 'entity_id');
    }

    public function children()
    {
        return $this->belongsToMany(Product::class, 'catalog_product_relation', 'parent_id', 'child_id');
    }

    public function parents()
    {
        return $this->belongsToMany(Product::class, 'catalog_product_relation', 'child_id', 'parent_id');
    }

    public function links()
    {
        return $this->belongsToMany(Product::class, 'catalog_product_link', 'product_id', 'linked_product_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'catalog_category_product', 'product_id', 'category_id');
    }

    public function galleries()
    {

    }

    public function tierprices()
    {
        return $this->hasMany(Tierprice::class, 'entity_id', 'entity_id');
    }

    public function entities($storeId = 0)
    {
        $storeArray = [0];
        if ($storeId !== 0) {
            $storeArray[] = $storeId;
        }
        return $this->texts()
            ->union($this->varchars()->whereIn('store_id', $storeArray)->toBase())
            ->union($this->decimals()->whereIn('store_id', $storeArray))
            ->union($this->datetimes()->whereIn('store_id', $storeArray))
            ->union($this->integers()->whereIn('store_id', $storeArray));
    }


}