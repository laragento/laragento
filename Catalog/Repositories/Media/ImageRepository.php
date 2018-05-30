<?php

namespace Laragento\Catalog\Repositories\Media;

use Laragento\Catalog\Models\Product\Entity\Media\MediaGallery;
use Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValue;
use Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValueToEntity;
use Laragento\MediaStorage\Managers\Image;
use Laragento\Catalog\Models\Product\Entity\Varchar;

class ImageRepository implements ImageRepositoryInterface
{
    /**
     * @param $imageData
     * @param $productId
     * @return bool|null|string
     */
    public function saveImage($imageData, $productId)
    {
        //only save image if required params are set
        if(!isset($imageData['name']) || !isset($imageData['source_path']) || !isset($imageData['target_path'])) {
            return false;
        }

        $imageManager = new Image();
        if(!$imageManager->save($imageData)) {
            return false;
        }

        $imageStorePath = $this->imagePathToStore($imageData['name']);

        $this->storeGallery($imageData, $productId, $imageStorePath);

        return true;
    }

    /**
     * @param $imageData
     * @param $productId
     * @param $imageStorePath
     */
    protected function storeGallery($imageData, $productId, $imageStorePath)
    {
        $mediaGallery = MediaGallery::where([
            'attribute_id' => 90,
            'media_type' => 'image',
            'value' => $imageStorePath,
        ])->first();

        if(!$mediaGallery) {
            //create new entry
            $mediaGallery = new MediaGallery([
                'attribute_id' => 90,
                'value' => $imageStorePath,
                'media_type' => 'image',
                'disabled' => 0,
            ]);
        } else {
            //update existing entry
            $mediaGallery->value = $imageStorePath;
            $mediaGallery->disabled = 0;
        }
        $mediaGallery->save();

        MediaGalleryValue::firstOrCreate([
            'value_id' => $mediaGallery->value_id,
            'store_id' => $imageData['store_id'],
            'entity_id' => $productId,
            'label' => $imageData['name'],
            'position' => 2,
            'disabled' => 0,
        ]);

        MediaGalleryValueToEntity::firstOrCreate([
            'value_id' => $mediaGallery->value_id,
            'entity_id' => $productId,
        ]);

        $this->saveThumbnail($productId, $imageData, 'image');
        $this->saveThumbnail($productId, $imageData, 'small_image');
        $this->saveThumbnail($productId, $imageData, 'thumbnail');
    }

    /**
     * @param $productId
     * @param $imageData
     * @param $type
     */
    public function saveThumbnail($productId, $imageData, $type)
    {
        $attribute_id = null;

        if ($type == 'image') {
            $attribute_id = 87;
        } elseif ($type == 'small_image') {
            $attribute_id = 88;
        } elseif ($type == 'thumbnail') {
            $attribute_id = 89;
        } else {
            dd('the image type is not valid');
        }

        $varchar = Varchar::where('entity_id', $productId)->where('attribute_id', $attribute_id)->first();
        if (!$varchar) {
            Varchar::create([
                'attribute_id' => $attribute_id,
                'store_id' => $imageData['store_id'],
                'entity_id' => $productId,
                'value' => $imageData['name'],
            ]);
        }
    }

    /**
     * @param $image
     * @return string
     */
    protected function storeSubPath($image)
    {
        return strtolower($image{0}) . '/' . strtolower($image{1});
    }

    /**
     * @param $image
     * @return string
     */
    protected function imagePathToStore($image)
    {
        return '/' . $this->storeSubPath($image) . '/' . $image;
    }

}