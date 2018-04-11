<?php

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laragento\Catalog\Repositories\Media\ImageRepository;
use Illuminate\Support\Facades\DB;
use Tests\CreatesApplication;

class ImageRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var ImageRepository
     */
    protected $imageRepository;

    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');
        $this->imageRepository = new ImageRepository();
        DB::beginTransaction();
    }

    public function testImportSingleNewImageFromImportFolder()
    {
        self::assertTrue(true);
    }

    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}