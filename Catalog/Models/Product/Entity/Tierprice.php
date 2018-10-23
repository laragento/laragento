<?php

namespace Laragento\Catalog\Models\Product\Entity;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;

/**
 * Laragento\Catalog\Models\Product\Entity\Tierprice
 *
 * @package Laragento\Catalog\Models\Product\Entity
 * @property int $value_id Value ID
 * @property int $entity_id Entity ID
 * @property int $all_groups Is Applicable To All Customer Groups
 * @property int $customer_group_id Customer Group ID
 * @property float $qty QTY
 * @property float $value Value
 * @property float|null $percentage_value Percentage value
 * @property int $website_id Website ID
 * @property-read \Laragento\Catalog\Models\Product\Product $attribute
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Tierprice whereAllGroups($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Tierprice whereCustomerGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Tierprice whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Tierprice wherePercentageValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Tierprice whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Tierprice whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Tierprice whereValueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Tierprice whereWebsiteId($value)
 * @mixin \Eloquent
 */
class Tierprice extends Model
{
    protected $table = 'catalog_product_entity_tier_price';
    protected $primaryKey = 'value_id';
    protected $fillable = [
        'entity_id',
        'all_groups',
        'customer_group_id',
        'qty',
        'value',
        'website_id'
    ];
    public $timestamps = false;

    public function attribute()
    {
        return $this->hasOne(Product::class, 'entity_id', 'entity_id');
    }
}