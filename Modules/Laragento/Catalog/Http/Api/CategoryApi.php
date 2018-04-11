<?php

namespace Laragento\Catalog\Http\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Fractal\Fractal;
use Laragento\Catalog\Repositories\Category\CategoryRepositoryInterface;
use Laragento\Catalog\Transformers\CategoryTransformer;

class CategoryApi extends Controller implements CategoryApiInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    protected $request;

    protected $storeId;

    /**
     * CategoryApi constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
    Request $request
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function first($identifier)
    {

        $fractal = Fractal::create(
            $this->categoryRepository->first($identifier),
            new CategoryTransformer()
        )
            ->parseIncludes('products,children');

        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function products($categoryId)
    {

        $fractal = Fractal::create(
            $this->categoryRepository->products($categoryId),
            new CategoryTransformer(['store_id' => $this->getStoreId()])
        )->parseIncludes('products');
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function children($categoryId)
    {
        $fractal = Fractal::create(
            $this->categoryRepository->children($categoryId),
            new CategoryTransformer()
        )->parseIncludes('children');
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function parent($categoryId)
    {
        $fractal = Fractal::create(
            $this->categoryRepository->parent($categoryId),
            new CategoryTransformer()
        )->parseIncludes('parent');
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function store($request)
    {

    }

    protected function getStoreId()
    {
        return $this->request->get('store_id');
        //return 2;
    }
}