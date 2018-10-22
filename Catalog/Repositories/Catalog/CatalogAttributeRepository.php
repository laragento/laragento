<?php

namespace Laragento\Catalog\Repositories\Catalog;

use Illuminate\Support\Facades\DB;
use Laragento\Eav\Models\Option\AttributeOptionValue;
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

    /**
     * @return \Illuminate\Support\Collection
     */
    public function filterableAttributes()
    {
        return DB::table('catalog_eav_attribute')
            ->where('is_filterable','=','1')
            ->join('eav_attribute',
                function ($join) {
                    $join->on('eav_attribute.attribute_id', '=', 'catalog_eav_attribute.attribute_id');
                }
            )
            ->get(['eav_attribute.attribute_id','attribute_code','frontend_label']);
    }

    /**
     * @todo remove is_filterable condition
     * @return \Illuminate\Support\Collection
     */
    public function attributeLabels()
    {
        return DB::table('catalog_eav_attribute')
            ->where('is_filterable','=','1')
            ->join('eav_attribute',
                function ($join) {
                    $join->on('eav_attribute.attribute_id', '=', 'catalog_eav_attribute.attribute_id')
                        ->where('eav_attribute.is_user_defined', '=', '1');
                }
            )
            ->get(['eav_attribute.attribute_id','attribute_code','frontend_label']);
    }

    public function indexedAttributeOptionValues($optionIdArray)
    {
        $optionValues = AttributeOptionValue::where(function ($query) use ($optionIdArray) {
            $query->whereIn('option_id', $optionIdArray);
        })->get(['option_id','value']);

        $indexedOptionValues = [];
        foreach ($optionValues->toArray() as &$row) {
            $indexedOptionValues[$row['option_id']] = &$row;
        }

        return $indexedOptionValues;
    }
}