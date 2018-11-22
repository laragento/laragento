<?php

namespace Laragento\Eav\Repositories;


interface AttributeRepositoryInterface
{
    const ENTITY_TYPE_ID = 4;

    public function attributesByAttributeSet($attributeSetId);

    public static function attribute($identifier);

    public static function attributeByCode($attributeCode, $entityTypeId = self::ENTITY_TYPE_ID);

    public static function attributeById($attributeId, $entityTypeId = self::ENTITY_TYPE_ID);

    public static function optionsByAttributeIdAndValues($attributeId, $values);
}