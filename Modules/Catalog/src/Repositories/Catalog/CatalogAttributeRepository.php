<?php

namespace Laragento\Catalog\Repositories\Catalog;

use Illuminate\Support\Facades\DB;
use Laragento\Eav\Repositories\AttributeRepository;

class CatalogAttributeRepository extends AttributeRepository implements CatalogAttributeRepositoryInterface
{
    const ENTITY_TYPE_ID = 4;
    protected $attributeSetId;

    /**
     * @param $attributeSetId
     * @return array
     */
    public function catalogAttributesByAttributeSet($attributeSetId)
    {
        $this->attributeSetId = $attributeSetId;
        return DB::table('eav_attribute')
            ->select('eav_attribute.attribute_id', 'frontend_label', 'attribute_code')
            ->join('eav_entity_attribute', function ($join) {
                $join->on('eav_attribute.attribute_id', '=', 'eav_entity_attribute.attribute_id')
                    ->where('eav_entity_attribute.attribute_set_id', '=', $this->attributeSetId);
            })
            ->join('catalog_eav_attribute', function ($join) {
                $join->on('eav_attribute.attribute_id', '=', 'catalog_eav_attribute.attribute_id');
            })
            ->where('is_visible_on_front', '=', 1)
            ->get()->toArray();
    }
}