<?php

namespace Laragento\Eav\Repositories;

use Illuminate\Support\Facades\DB;
use Laragento\Eav\Models\Attribute;

class AttributeRepository implements AttributeRepositoryInterface
{
    const ENTITY_TYPE_ID = 4;
    protected $attributeSetId;

    /**
     * @param $attributeSetId
     * @return array
     */
    public function attributesByAttributeSet($attributeSetId)
    {
        $this->attributeSetId = $attributeSetId;
        return DB::table('eav_attribute')
            ->join('eav_entity_attribute', function ($join) {
                $join->on('eav_attribute.attribute_id', '=', 'eav_entity_attribute.attribute_id')
                    ->where('eav_entity_attribute.attribute_set_id', '=', $this->attributeSetId);
            })
            ->get()->toArray();
    }

    /**
     * @param $identifier
     * @return mixed
     */
    public static function attribute($identifier)
    {
        if (is_numeric($identifier)) {
            return self::attributeById($identifier);
        }
        return self::attributeByCode($identifier);
    }

    /**
     * @param $attributeCode
     * @return mixed
     */
    public static function attributeByCode($attributeCode)
    {
        return Attribute::whereAttributeCode($attributeCode)->whereEntityTypeId(self::ENTITY_TYPE_ID)->first();
    }

    /**
     * @param $attributeId
     * @return mixed
     */
    public static function attributeById($attributeId)
    {
        return Attribute::whereAttributeId($attributeId)->whereEntityTypeId(self::ENTITY_TYPE_ID)->first();
    }

    /**
     * @param $attributeId
     * @param $values
     * @return \Illuminate\Support\Collection
     *
     * @todo once again... shitty hardcoded store id
     */
    public static function optionsByAttributeIdAndValues($attributeId, $values)
    {
        return DB::table('eav_attribute_option')
            ->select('eav_attribute_option.option_id')
            ->join('eav_attribute_option_value', function ($join) use ($values) {
                $join->on('eav_attribute_option.option_id', '=', 'eav_attribute_option_value.option_id')
                    ->where(function ($query) use ($values) {
                        if (!is_array($values)) {
                            $query->where('eav_attribute_option_value.value', '=', $values);
                        }
                        foreach ($values as $value) {
                            $query->orWhere('eav_attribute_option_value.value', '=', $value);
                        }
                    });
            })
            ->where('eav_attribute_option.attribute_id', '=', $attributeId)
            ->where('eav_attribute_option_value.store_id', '=', 0)
            ->get();
    }


}