<?php


use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\TestCase;
use Laragento\Catalog\Models\Product\Entity\Media\MediaGallery;
use Laragento\ImportExport\Managers\Import\ImportInterface;
use Mexan\XmlImportExport\Managers\Import\XmlProductImport;
use Tests\CreatesApplication;

class ExampleMediaTest extends TestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();
        DB::beginTransaction();
    }

    /**
     *
     */
    public function testImportProductXml()
    {
        $gallery = MediaGallery::where([
            'attribute_id' => 90,
            'value' => '_update',
            'media_type' =>'image'
        ])->find();
        print_r($gallery);
    }

    /**
     *
     */
    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }


}
