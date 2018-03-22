<?php

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Laragento\Eav\Repositories\AttributeRepository;
use Tests\CreatesApplication;

class AttributeRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var AttributeRepository
     */
    protected $attributeRepository;

    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');
        $this->attributeRepository = new AttributeRepository();
        DB::beginTransaction();
    }

    public function testGetSingleAttributeByCode()
    {
        $attributeCode = 'name';
        $attribute = $this->attributeRepository::attribute($attributeCode);
        $this->assertEquals($attribute->attribute_code, $attributeCode);
    }

    /**
     * @todo constant for attribute set
     * @todo make better assertions
     */
    public function testGetAttributesByAttributeSet()
    {
        $attributeSet = collect($this->attributeRepository->attributesByAttributeSet(4));

        $name = $attributeSet->filter(function ($item) {
            return $item->attribute_code == "name";
        })->first();
        $this->assertEquals($name->attribute_code, 'name');

        $nonExistingAttributeCode = $attributeSet->filter(function ($item) {
            return $item->attribute_code == "not-existing-attribute-code";
        })->first();
        $this->assertNull($nonExistingAttributeCode);
    }


    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}