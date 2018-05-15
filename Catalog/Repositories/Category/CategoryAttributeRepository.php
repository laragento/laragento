<?php

namespace Laragento\Catalog\Repositories\Category;

use Illuminate\Database\QueryException;
use Laragento\Catalog\Models\Category\Entity\Datetime;
use Laragento\Catalog\Models\Category\Entity\Decimal;
use Laragento\Catalog\Models\Category\Entity\Integer;
use Laragento\Catalog\Models\Category\Entity\Text;
use Laragento\Catalog\Models\Category\Entity\Varchar;
use Laragento\Catalog\Models\Category\Category;
use Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepositoryInterface;
use Laragento\Eav\Repositories\AttributeRepositoryInterface;

class CategoryAttributeRepository implements CategoryAttributeRepositoryInterface
{
    const IN_DELIMITER = '|';
    const STORE_DELIMITER = ',';

    protected $errors;
    protected $attributeRepository;
    protected $catalogAttributeRepository;

    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        CatalogAttributeRepositoryInterface $catalogAttributeRepository
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->catalogAttributeRepository = $catalogAttributeRepository;
    }

    /**
     * Returns attribute value by product id and attribute code
     *
     * @param $attributeCode
     * @param $categoryId
     * @param int $storeId
     * @return bool
     * @throws \Exception
     */
    public function data($attributeCode, $categoryId, $storeId = 0)
    {
        $attribute = $this->attributeRepository::attributeByCode($attributeCode, 3);
        if (!$attribute) {
            throw new \Exception('Attribute Code ' . $attributeCode . ' not found');
        }
        $where = [
            'attribute_id' => $attribute->attribute_id,
            'entity_id' => $categoryId,
            'store_id' => $storeId
        ];
        return $this->dataByAttribute($attribute,$where);
    }

    /**
     * Returns true when the value is not yet in the database
     *
     * @param $attributeCode
     * @param $value
     * @param $categoryId
     * @return mixed
     * @throws \Exception
     */
    public function isDataUnique($attributeCode, $value, $categoryId)
    {
        $attribute = $this->attributeRepository::attributeByCode($attributeCode, 3);
        if (!$attribute) {
            throw new \Exception('Attribute Code ' . $attributeCode . ' not found');
        }
        $where = [
            'attribute_id' => $attribute->attribute_id,
            'value' => $value
        ];
        $compare = $this->dataByAttribute($attribute,$where);
        if($compare){
            if($compare->entity_id != $categoryId){
                return false;
            }
            return true;
        }
        return true;
    }

    /**
     * @param $attribute
     * @param $where
     * @return mixed
     *
     */
    public function dataByAttribute($attribute,$where){
        switch ($attribute->backend_type) {
            case 'varchar':
                return Varchar::where($where)->first();
            case 'int':
                return Integer::where($where)->first();
            case 'text':
                return Text::where($where)->first();
            case 'decimal':
                return Decimal::where($where)->first();
            case 'datetime':
                return Datetime::where($where)->first();
            default :
                $this->errors[] = 'backend_type' . $attribute->backend_type . 'is missing';
        }
    }

    /**
     * @param $categoryId
     * @return array
     */
    public function get($categoryId)
    {
        $attributeValues = [];
        $attributes = $this->catalogAttributeRepository->catalogAttributesByAttributeSet(3);

        $category = Category::with('entities.attribute')
            ->where(['entity_id' => $categoryId])
            ->first();

        foreach ($category->entities as $entity) {
            $values[$entity->attribute->attribute_id] = $entity->value;
        }

        foreach ($attributes as $attribute) {
            $entity = [
                'attribute_id' => $attribute->attribute_id,
                'attribute_code' => $attribute->attribute_code,
                'frontend_label' => $attribute->frontend_label,
            ];
            if (isset($values[$attribute->attribute_id])) {
                $entity['value'] = $values[$attribute->attribute_id];
                $attributeValues[] = $entity;
            }
        }
        return $attributeValues;
    }

    /**
     * @param $attributeData
     * @param $category
     * @todo take care of the attribute set id
     */
    public function save($attributeData, $category)
    {
        $attributes = $this->attributeRepository->attributesByAttributeSet(3);

        foreach ($attributes as $attribute) {
            $entity = [
                'attribute_id' => $attribute->attribute_id,
                'store_id' => $attributeData['store_id'],
                'entity_id' => $category->entity_id
            ];

            if (isset($attributeData[$attribute->attribute_code])) {
                //if found in array, value value for attribute_code
                $entity['value'] = $attributeData[$attribute->attribute_code];
                $this->saveEntity($attribute, $entity);
            } else {
                //if not found in array, set default_value for attribute
                if ($attribute->default_value != null) {
                    $entity['value'] = $attribute->default_value;
                    $this->saveEntity($attribute, $entity);
                }
            }
        }
    }

    /**
     * @param $attribute
     * @param $entity
     * @return null
     */
    public function saveEntity($attribute, $entity)
    {
        if (in_array($attribute->backend_type, ['varchar', 'int', 'text', 'decimal', 'datetime'])) {
            $var = false;
            $value = $entity['value'];
            $where = [
                'attribute_id' => $attribute->attribute_id,
                'entity_id' => $entity['entity_id'],
                'store_id' => $entity['store_id'],
            ];
            try {
                if ($attribute->frontend_input == 'multiselect') {
                    $value = $this->getMultiselectValue($attribute, $value);
                    if (!$value) {
                        return null;
                    }
                }

                switch ($attribute->backend_type) {
                    case 'varchar':
                        $var = Varchar::firstOrNew($where);
                        break;
                    case 'int':
                        $var = Integer::firstOrNew($where);
                        break;
                    case 'text':
                        $var = Text::firstOrNew($where);
                        break;
                    case 'decimal':
                        $var = Decimal::firstOrNew($where);
                        break;
                    case 'datetime':
                        $var = Datetime::firstOrNew($where);
                        break;
                    default :
                        $this->errors[] = 'backend_type' . $attribute->backend_type . 'is missing';
                }
                if ($var) {
                    $var->value = $value;
                    // @todo > start  special case for unique url-key; find better solution!
                    if($attribute->attribute_code == 'url_key'){
                        try{
                            $i=1;
                            if(!$this->isDataUnique($attribute->attribute_code,$value,$entity['entity_id'])){
                                $value = $value.'-'.$i;
                                if(!$this->isDataUnique($attribute->attribute_code,$value,$entity['entity_id'])){
                                    $value = $value.'-'.$i;  //@todo what happens when the -1-2 already exists?! (while?)
                                }
                                $var->value = $value;
                            }
                        }catch (\Exception $e){
                            dd($e->getMessage());
                        }
                    }
                    // @todo end <
                    $var->save();
                }
            } catch (QueryException $queryException) {
                print_r('[' . $attribute->attribute_id . '] ' . $attribute->attribute_code . ' is missing !!!!!!!!');
            }
        }
    }

    /**
     * @param $attribute
     * @param $value
     * @return string
     */
    public function getMultiselectValue($attribute, $value)
    {
        $values = explode(self::IN_DELIMITER, $value);
        $options = $this->attributeRepository::optionsByAttributeIdAndValues($attribute->attribute_id, $values);
        $returnValue = '';
        foreach ($options as $option) {
            $returnValue .= $option->option_id . self::STORE_DELIMITER;
        }
        return trim($returnValue, self::STORE_DELIMITER);
    }
}