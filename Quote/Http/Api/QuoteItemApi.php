<?php

namespace Laragento\Quote\Http\Api;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Catalog\Repositories\Product\ProductRepository;
use Laragento\Catalog\Transformers\ChildProductTransformer;
use Laragento\Quote\DataObjects\QuoteSessionItem;
use Laragento\Quote\Managers\QuoteItemManager;
use Laragento\Quote\Repositories\QuoteSessionItemRepository;
use Laragento\Quote\Repositories\QuoteSessionItemRepositoryInterface;
use Laragento\Quote\Transformers\QuoteItemTransformer;
use Spatie\Fractal\Fractal;

class QuoteItemApi extends Controller
{

    protected $quoteItemRepository;
    protected $productRepository;
    protected $manager;

    /**
     * QuoteController constructor.
     * @param QuoteSessionItemRepositoryInterface $quoteItemRepository
     * @param QuoteItemManager $quoteItemManager
     * @param ProductRepository $productRepository
     */
    public function __construct(
        QuoteSessionItemRepositoryInterface $quoteItemRepository,
        QuoteItemManager $quoteItemManager,
        ProductRepository $productRepository
    )
    {
        $this->quoteItemRepository = $quoteItemRepository;
        $this->manager = $quoteItemManager;
        $this->productRepository = $productRepository;

        $this->middleware('auth')->except([]);
    }


    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store()
    {
        $requestData = request()->all();
        $item = $this->quoteItemRepository->byProductId($requestData['product_id']);;

        $this->manager->storeItems($requestData,$item);

        $items = $this->quoteItemRepository->get();
        $response = Fractal::create(end($items), new QuoteItemTransformer());

        return response()->json($response,201);
    }

    /**
     * Show the specified resource.
     * @return array
     */
    public function get()
    {
        return $this->quoteItemRepository->get();
    }

    /**
     * Show the specified resource.
     * @param $id
     * @return Response
     */
    public function find($id)
    {
        $item = $this->quoteItemRepository->byId($id);
        $response = Fractal::create($item, new QuoteItemTransformer());
        return response()->json($response,200);
    }

    /**
     * Show the specified resource.
     * @param $productId
     * @return Response
     */
    public function byProduct($productId)
    {
        $item = $this->quoteItemRepository->byProductId($productId);
        $response = Fractal::create($item, new QuoteItemTransformer());
        return response()->json($response,200);
    }

    /**
     * Show the specified resource.
     * @param $itemId
     * @return Response
     */
    public function productByItem($itemId)
    {
        /** @var QuoteSessionItem $item */
        $item = $this->quoteItemRepository->byId($itemId);
        $product = $this->productRepository->byId($item->getProductId());
        $response = Fractal::create($product, new ChildProductTransformer());
        return response()->json($response,200);
    }

    /**
     * Update the specified resource in storage.
     * @param $itemId
     * @return Response
     */
    public function update($itemId)
    {
        $requestData = request()->all();

        // Update Item Data
        $items = $this->quoteItemRepository->updateItem($itemId, $requestData);

        // Store Data in Cart
        $this->manager->storeItems($items);
        $response = Fractal::create(end($items), new QuoteItemTransformer());
        return response()->json($response,200);
    }

    /**
     * Remove the specified resource from storage.
     * @param $itemId
     * @return Response
     */
    public function destroy($itemId)
    {
        $items = $this->quoteItemRepository->destroyItem($itemId);
        $this->manager->storeItems($items);

        return response()->json([],204);
    }


}
