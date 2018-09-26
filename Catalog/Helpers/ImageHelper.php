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
        //only run exec in production mode
        if(App::environment() != 'production') {
            return url(config('catalog.placeholder_image_path'));
        }

        $cache = Cache::get('product-image-' . $productId . '-' . $width . '-' . $height);
        if($cache != null) {
            return $cache;
        }

        $output = null;
        exec('/usr/bin/php -f ' . config('catalog.magento_category_image_path') . ' ' . $productId . ' ' . $width . ' ' . $height,$output);
        $result = '';
        if(isset($output[0])) {
            $result = $output[0];
        }

        //cache image one day
        Cache::put('product-image-' . $productId . '-' . $width . '-' . $height, $result, 60);

        return $result;
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

        if(count($execProductIds) == 0) {
            return $result;
        }

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
}