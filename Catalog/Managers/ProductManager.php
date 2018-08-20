<?php

namespace Laragento\Catalog\Managers;

use Laragento\Catalog\Repositories\Product\ProductAttributeRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;
use Laragento\Catalog\Helpers\ImageHelper;

class ProductManager {
    protected $productRepository;
    protected $productAttributeRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->productAttributeRepository = $productAttributeRepository;
    }

    /**
     * map product index data with additional data for view
     *
     * @param $productData
     * @return mixed
     */
    public function mapProductData($productData) {
        $productData['path'] = route('product.show', ['product_slug' => trim($productData['name'])]);
        return $productData;
    }

    /**
     * @param $products
     * @return array
     */
    public function mapProductDataArray($products)
    {
        foreach ($products as $i => $product) {
            $products[$i] = $this->mapProductData($product->toArray());
        }
        return $products;
    }

    /**
     * @param $relatedProducts
     * @param int $width
     * @param int $height
     * @return array
     */
    public function getProductImages($relatedProducts,$width = 240, $height = 240)
    {
        $productGridImages = [];
        if (count($relatedProducts) > 0) {
            $productGridImages = ImageHelper::getImageURLs($relatedProducts->pluck('catalog_category_product.product_id')->toArray(),
                $width, $height);
        }
        return $productGridImages;
    }
}