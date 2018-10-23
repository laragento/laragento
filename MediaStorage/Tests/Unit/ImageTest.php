<?php

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laragento\MediaStorage\Managers\Image;
use Tests\CreatesApplication;

class ImageTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var Image
     */
    protected $imageManager;

    public function setUp()
    {
        parent::setUp();
        $this->imageManager = new Image();
    }

    public function testImportNewImageFromImportFolder()
    {
        $imageName = '__testImage.jpg';
        $image = $this->imageManager->save($imageName);
        $this->assertEquals($image, '/_/_/' . $imageName);

        $exists = File::exists($this->imageManager->targetPath($imageName));
        $this->assertTrue($exists);
        if ($exists) {
            File::delete($this->imageManager->targetPath($imageName));
        }
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}