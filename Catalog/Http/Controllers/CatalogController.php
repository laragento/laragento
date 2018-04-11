<?php

namespace Laragento\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use Laragento\Catalog\Transformers\CategoryTransformer;
use Laragento\Catalog\Transformers\GroupedProductTransformer;
use Spatie\Fractal\Fractal;
use Laragento\Catalog\Support\Facades\ProductFacade;
use Laragento\Catalog\Support\Facades\CategoryFacade;
use Laragento\Catalog\Repositories\Category\CategoryRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;

class CatalogController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * CatalogController constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param $product_slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product($product_slug)
    {
        dd($this->productRepository->first($product_slug));
        $fractal = Fractal::create(
            $this->productRepository->first($product_slug),
            new GroupedProductTransformer()
        )
            ->parseIncludes('products,children')
            ->toJson();

        return view('frontend_catalog::product', [
            'product' => json_decode($fractal)->data,
            //'attributes' => ProductFacade::attributeList(4),
        ]);
    }

    /**
     * @param $categoryId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($categoryId)
    {
        $fractal = Fractal::create(
            $this->categoryRepository->first($categoryId),
            new CategoryTransformer()
        )
            ->parseIncludes('products,children')
            ->toJson();

        return view('frontend_catalog::category', [
            'products' => '',
            'category' => json_decode($fractal)->data,
        ]);
    }
}
