<?php

namespace Laragento\Catalog\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class ImageHelper
{
    /**
     * get Image url for single image
     *
     * @param $productId
     * @param $width
     * @param $height
     * @return string
     */
    public static function getImageURL($productId, $width, $height) {
        $images = self::getImageURLs([$productId], $width, $height);
        return $images[$productId];
    }

    /**
     * get Images for image array
     *
     * @param $productIds
     * @param $width
     * @param $height
     * @return array
     */
    public static function getImageURLs($productIds, $width, $height) {

        $result = [];
        //only run exec in production mode
        if(App::environment() != 'production') {
            foreach($productIds as $productId) {
                $result[$productId] = url(config('catalog.placeholder_image_path'));
            }

            return $result;
        }

        //get products in cache and set productIds who should be fetched from Magento System
        $execProductIds = [];
        foreach($productIds as $productId) {
            $cache = Cache::get('product-image-' . $productId . '-' . $width . '-' . $height);
            if($cache != null) {
                $result[$productId] = $cache;
                continue;
            }
            $execProductIds[] = $productId;
        }
        //dd(count($execProductIds));
        if(count($execProductIds) == 0) {
            return $result;
        }

        if(config('catalog.magento_access_images_method') == 'file_get_content'){
            return self::runFileGetContent($execProductIds, $width, $height, $result);
        }else{
            return self::runExecute($execProductIds, $width, $height, $result);
        }
    }

    public static function runFileGetContent($execProductIds, $width, $height, $result)
    {
        $productIdsParams = implode("=",$execProductIds);
        $imagesJson = file_get_contents(config('catalog.magento_images_complete_url').'image.php?ids='.$productIdsParams.'&width='.$width.'&height='.$height);
        $images = json_decode($imagesJson, true);

        foreach ($images as $key =>$image){
            $result[$image['product_id']] = $image['images'][0]['image_url'];
            Cache::put('product-image-' . $image['product_id'] . '-' . $width . '-' . $height, $image['images'][0]['image_url'], 60); //cache image one day
        }

        return $result;
    }

    public static function runExecute($execProductIds, $width, $height, $result)
    {
        $exec = '';
        foreach($execProductIds as $execProductId) {
            $exec .= ' ' . $execProductId . ' ' . $width . ' ' . $height;
        }

        //execute image.php from Magento
        $output = null;

        exec('/usr/bin/php -f ' . config('catalog.magento_image_helper') . $exec,$output);

        //map results
        foreach($execProductIds as $key => $execProductId) {
            if(!isset($output[$key])) {
                continue;
            }

            $result[$execProductId] = $output[$key];
            Cache::put('product-image-' . $execProductId . '-' . $width . '-' . $height, $output[$key], 60); //cache image one day
        }

        return $result;
    }


    public static function runCategoryFileGetContent($execProductIds, $width, $height, $result)
    {
        $productIdsParams = implode("=",$execProductIds);
        $imagesJson = file_get_contents(config('catalog.magento_images_complete_url').'category_image.php?ids='.$productIdsParams.'&width='.$width.'&height='.$height);
        $images = json_decode($imagesJson, true);

        foreach ($images as $key =>$image){
            $result[$image['category_id']] = $image['images'][0]['image_url'];
            Cache::put('category-image-' . $image['category_id'] . '-' . $width . '-' . $height, $image['images'][0]['image_url'], 60); //cache image one day
        }

        return $result;
    }


    public static function getCategoryImageURL($categoryId, $width, $height) {
        $images = self::getCategoryImageURLs([$categoryId], $width, $height);
        return $images[$categoryId];
    }

    /**
     * Get images for category image array
     *
     * @param $categoryIds
     * @param $width
     * @param $height
     * @return array
     */
    public static function getCategoryImageURLs($categoryIds, $width, $height) {

        $result = [];
        $execCategoryIds = [];
        //only run exec in production mode
//        if(App::environment() != 'production') {
//            foreach($categoryIds as $categoryId) {
//                $result[$categoryId] = url(config('catalog.placeholder_image_path'));
//            }
//
//            return $result;
//        }


        //get products in cache and set productIds who should be fetched from Magento System
        $execProductIds = [];
        foreach($categoryIds as $categoryId) {
            $cache = Cache::get('category-image-' . $categoryId . '-' . $width . '-' . $height);
            if($cache != null) {
                $result[$categoryId] = $cache;
                continue;
            }
            $execCategoryIds[] = $categoryId;
        }
        if(count($execCategoryIds) == 0) {
            return $result;
        }

        if(config('catalog.magento_access_images_method') == 'file_get_content'){
            return self::runCategoryFileGetContent($execCategoryIds, $width, $height, $result);
        }else{
            return self::runExecute($categoryIds, $width, $height, $result);
        }
    }
}