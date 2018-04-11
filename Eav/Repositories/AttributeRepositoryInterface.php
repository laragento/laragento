<?php

namespace Laragento\Eav\Repositories;


interface AttributeRepositoryInterface
{
    public function attributesByAttributeSet($attributeSetId);

    public static function attribute($identifier);

    public static function attributeByCode($attributeCode);

    public static function attributeById($attributeId);

    public static function optionsByAttributeIdAndValues($attributeId, $values);
}