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
        $image = $imageManager->save($imageData);
        /*
        if ($image) {
            $this->storeGallery($image, $productId, $label);
        }*/

        return $image;
    }

    /**
     * @param $image
     * @param $productId
     * @param $label
     * @param int $position
     * @todo handle store id
     * @todo refactor this method!
     */
    protected function storeGallery($image, $productId, $label, $position = 2)
    {
        $mgvte = MediaGalleryValueToEntity::where('entity_id', $productId)->get();

        //ToDo we have to configure behavior for empty Image Value
        if ($image !== null) {
        //if ($mgvte->isEmpty()) {
            $mediaGalleryData = [
                'attribute_id' => 90,
                'value' => $image,
                'media_type' => 'image',
                'disabled' => 0,
            ];

            //print_r($mediaGalleryData);

            $mediaGallery = MediaGallery::where(
                [
                    'attribute_id' => 90,
                    'media_type' => 'image',
                    'value' => $image,
                ]
            )->first();

            if (!$mediaGallery) {
                print_r($image. 'Im new');
                $mediaGallery = new MediaGallery($mediaGalleryData);
                $mediaGallery->save();
            } else {
                print_r('Im updateing');
                $mediaGalleryData['value'] = $image;
                $mediaGallery->update($mediaGalleryData);
            }

            MediaGalleryValue::firstOrCreate([
                'value_id' => $mediaGallery->value_id,
                'store_id' => 0,
                'entity_id' => $productId,
                'label' => $label,
                'position' => 2,
                'disabled' => 0,
            ]);

            MediaGalleryValueToEntity::firstOrCreate([
                'value_id' => $mediaGallery->value_id,
                'entity_id' => $productId,
            ]);

            $this->saveThumbnail($productId, $image, 'image');
            $this->saveThumbnail($productId, $image, 'small_image');
            $this->saveThumbnail($productId, $image, 'thumbnail');
        }

        //} else {
            //@todo implement gallery update
        //}
    }

    public function saveThumbnail($productId, $image, $type)
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
                'store_id' => 0,
                'entity_id' => $productId,
                'value' => $image,
            ]);
        }
    }


}