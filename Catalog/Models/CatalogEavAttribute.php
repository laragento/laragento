<?php

namespace Laragento\Catalog\Models\Category;

use Illuminate\Database\Eloquent\Model;
use Laragento\Eav\Models\Attribute;

/**
 * Class CatalogEavAttribute
 * @package Laragento\Catalog\Models\Category
 */
class CatalogEavAttribute extends Model
{
    protected $table = 'catalog_eav_attribute';
    protected $fillable = [
        'attribute_id',
        'frontend_input_renderer',
        'is_global',
        'is_visible',
        'is_searchable',
        'is_filterable',
        'is_comparable',
        'is_visible_on_front',
        'is_used_for_price_rules',
        'is_filterable_in_search',
        'used_in_product_listing',
        'used_for_sort_by',
        'apply_to',
        'is_visible_in_advanced_search',
        'position',
        'is_wysiwyg_enabled',
        'is_used_for_promo_rules',
        'is_required_in_admin_store',
        'is_used_in_grid',
        'is_visible_in_grid',
        'is_filterable_in_grid',
        'search_weight',
        'additional_data',
    ];
    protected $primaryKey = 'attribute_id';

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'attribute_id');
    }
}