<?php

namespace Laragento\Catalog\Http\Api;

use App\Http\Controllers\Controller;
use Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductAttributeRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;
use Laragento\Catalog\Transformers\GroupedProductTransformer;
use Spatie\Fractal\Fractal;

class ProductApi extends Controller implements ProductApiInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var CatalogAttributeRepositoryInterface
     */
    protected $catalogAttributeRepository;

    /**
     * @var ProductAttributeRepositoryInterface
     */
    protected $productAttributeRepository;

    /**
     * ProductApi constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param ProductAttributeRepositoryInterface $productAttributeRepository
     * @param CatalogAttributeRepositoryInterface $catalogAttributeRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository,
        CatalogAttributeRepositoryInterface $catalogAttributeRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->catalogAttributeRepository = $catalogAttributeRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function first($identifier)
    {
        // @TODO don't assume that the first product is an GroupedProduct
        $fractal = Fractal::create(
            $this->productRepository::first($identifier),
            new GroupedProductTransformer()
        );
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function attributeList($attributeSetId)
    {
        return response()
            ->json(
                $this->catalogAttributeRepository->catalogAttributesByAttributeSet($attributeSetId)
            );
    }

    /**
     * {@inheritDoc}
     */
    public function attributeListWithValues($productId)
    {
        return response()
            ->json(
                $this->productAttributeRepository->get($productId)
            );
    }

    /**
     * {@inheritDoc}
     */
    public function newest($limit)
    {
        // @TODO don't assume that the newest product is an GroupedProduct
        $fractal = Fractal::create(
            $this->productRepository::newest($limit),
            new GroupedProductTransformer()
        );
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function store($request)
    {
        return response()
            ->json(
                $this->productRepository->store($request, null)
            );
    }

    /**
     * {@inheritDoc}
     */
    public function parentsBySku($sku)
    {
        return response()
            ->json(
                $this->productRepository::parentsBySku($sku)
            );
    }

    /**
     * {@inheritDoc}
     */
    public function getIdBySku($sku)
    {
        return response()
            ->json(
                $this->productRepository::getIdBySku($sku)
            );
    }
}