<?php

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laragento\Catalog\Models\Product\Product;
use Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepository;
use Laragento\Catalog\Repositories\Product\ProductAttributeRepository;
use Laragento\Eav\Models\Attribute;
use Illuminate\Support\Facades\DB;
use Laragento\Eav\Repositories\AttributeRepository;
use Tests\CreatesApplication;

abstract class AbstractProductAttributeRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var AttributeRepository
     */
    protected $attributeRepository;

    /**
     * @var ProductAttributeRepository
     */
    protected $productAttributeRepository;

    /**
     * @var CatalogAttributeRepository
     */
    protected $catalogAttributeRepository;

    /**
     * @var Product
     */
    protected $product1;

    /**
     * @var Product
     */
    protected $product2;

    /**
     * @var Attribute
     */
    protected $attribute;

    /**
     * @array
     */
    protected $entityArray;


    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');

        $this->attributeRepository = new AttributeRepository();
        $this->catalogAttributeRepository = new CatalogAttributeRepository();

        $this->productAttributeRepository = new ProductAttributeRepository(
            $this->attributeRepository,
            $this->catalogAttributeRepository
        );
        DB::beginTransaction();

        $this->initializeProduct1();
        $this->initializeProduct2();
        $this->initializeAttribute();
        $this->initializeEntityArray();
    }

    protected function initializeProduct1()
    {
        // save/get product
        $product = [
            'attribute_set_id' => 4,
            'type_id' => 'simple',
            'sku' => 'non-existing-sku1',
            'has_options' => 0,
            'required_options' => 0,
        ];

        $this->product1 = new Product($product);
        $this->product1->save();
    }

    protected function initializeProduct2()
    {
        // save/get product
        $product = [
            'attribute_set_id' => 4,
            'type_id' => 'simple',
            'sku' => 'non-existing-sku2',
            'has_options' => 0,
            'required_options' => 0,
        ];

        $this->product2 = new Product($product);
        $this->product2->save();
    }

    protected function initializeAttribute()
    {
        // attribute code
        $attributeCode = 'name';

        // get attribute
        $this->attribute = $this->attributeRepository::attribute($attributeCode);
    }

    protected function initializeEntityArray()
    {
        // entity
        $this->entityArray = [
            'attribute_id' => $this->attribute->attribute_id,
            'store_id' => 0,
            'entity_id' => $this->product1->entity_id,
            'value' => 'some random value'
        ];
    }

    protected function getAttributeData($productId)
    {
        try{
            return $this->productAttributeRepository->data($this->attribute->attribute_code, $productId);
        }catch (\Exception $e)
        {
            print_r($e->getMessage());
        }
        return null;
    }

    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}