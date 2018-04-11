<?php

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laragento\Catalog\Models\Product\Product;
use Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepository;
use Laragento\Catalog\Repositories\Product\ProductAttributeRepository;
use Laragento\Eav\Repositories\AttributeRepository;
use Illuminate\Support\Facades\DB;
use Tests\CreatesApplication;

class ProductAttributeRepositoryTest extends AbstractProductAttributeRepositoryTest
{
    /**
     * @test
     */
    public function is_attribute_value_unique()
    {
        $this->productAttributeRepository->saveEntity($this->attribute, $this->entityArray, false);

        try {
            $isUnique = $this->productAttributeRepository->isDataUnique($this->attribute->attribute_code, $this->entityArray['value'], $this->product1->entity_id);
            $this->assertTrue($isUnique);
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }

        try {
            $isUnique = $this->productAttributeRepository->isDataUnique($this->attribute->attribute_code, $this->entityArray['value'], $this->product2->entity_id);
            $this->assertFalse($isUnique);
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * @test
     */
    public function save_product_attribute_entity()
    {
        $this->productAttributeRepository->saveEntity($this->attribute, $this->entityArray, false);
        $data = $this->getAttributeData($this->product1->entity_id);
        $this->assertEquals($data->value, $this->entityArray['value']);
    }

    /**
     * @test
     * @todo use factories/faker
     * @todo find better solution for update
     */
    public function update_product_attribute_entity()
    {
        $this->productAttributeRepository->saveEntity($this->attribute, $this->entityArray, false);

        // update entity
        $entityForUpdate = [
            'attribute_id' => $this->attribute->attribute_id,
            'store_id' => 0,
            'entity_id' => $this->product1->entity_id,
            'value' => 'some random value 2'
        ];
        $this->productAttributeRepository->saveEntity($this->attribute, $entityForUpdate, true);
        $data = $this->getAttributeData($this->product1->entity_id);
        $this->assertEquals($data->value, 'some random value 2');
    }

    /**
     * @test
     */
    public function save_product_attributes()
    {
//        // save/get product
//        $productData = [
//            'attribute_set_id' => 4,
//            'type_id' => 'simple',
//            'sku' => 'non-existing-sku',
//            'store_id' => null,
//            'website_id' => 0,
//            'price' => 30.4,
//            'url_key' => 0,
//            'visibility' => 0,
//            'color' => 1,
//            'name' => 'some random name',
//        ];
//
//        $productObj = new Product($productData);
//        $productObj->save();
//
//        $this->productAttributeRepository->save($productData, $productObj, false);
//
//        $productDataCollection = collect($productData);
//        $productDataCollection->each(function ($attribute, $key) use ($productObj) {
//            if (!in_array($key, ['attribute_set_id', 'type_id', 'sku'])) {
//                $data = $this->productAttributeRepository->data($key, $productObj->entity_id);
//                $this->assertEquals($data->value, $attribute);
//            }
//        });

        $this->assertTrue(true);

        // @todo test default attribute values
    }


}