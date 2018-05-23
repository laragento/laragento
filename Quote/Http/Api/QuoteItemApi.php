<?php

namespace Laragento\Quote\Http\Api;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Catalog\Repositories\Product\ProductRepository;
use Laragento\Quote\Repositories\QuoteSessionItemRepository;
use Laragento\Quote\Repositories\QuoteSessionObjectRepository;

class QuoteItemApi extends Controller
{

    protected $quoteItemRepository;
    protected $quote;
    protected $quoteDataRepository;
    protected $productRepository;

    /**
     * QuoteController constructor.
     */
    public function __construct(
        QuoteSessionItemRepository $quoteItemRepository,
        QuoteSessionObjectRepository $quoteDataRepository,
        ProductRepository $productRepository
    )
    {

        $this->quoteItemRepository = $quoteItemRepository;
        $this->quoteDataRepository = $quoteDataRepository;
        $this->productRepository = $productRepository;
        $this->quote = session('laragento_cart');
        $this->middleware('auth')->except([]);
    }


    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store()
    {
        $itemData = request()->all();
        $lastId = end($this->quote['items']);
        if ($lastId) {
            $itemData['item_id'] = $lastId;
        } else {
            $itemData['item_id'] = 1;
        }
        $item = $this->quoteItemRepository->createItem($itemData);
        $this->quote['items'][] = $item;
        $this->settingQuoteItemsInfo();

        return response()->json($item->toArray(),201);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function get()
    {
        $items = $this->quoteItemRepository->get();
        return response()->json($items);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function find($id)
    {
        $item = $this->quoteItemRepository->byId($id);
        return response()->json($item->toArray());
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function byProduct($productId)
    {
        $item = $this->quoteItemRepository->byProductId($productId);
        return response()->json($item->toArray());
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function productByItem($itemId)
    {
        $item = $this->quoteItemRepository->byId($itemId);
        $product = $this->productRepository->byId($item->getProductId());
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     * @return Response
     */
    public function update($itemId)
    {
        $itemdata = request()->all();
        $item = $this->quoteItemRepository->updateItem($itemId, $itemdata);
        return response()->json($item->toArray());
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($itemId)
    {
        $items = $this->quoteItemRepository->destroyItem($itemId);
        $this->quote['items'] = $items;
        $this->settingQuoteItemsInfo();

        return response()->json([],204);
    }

    private function settingQuoteItemsInfo()
    {
        $this->quote['items_count'] = count($this->quote['items']);
        $this->quote['items_qty'] = count($this->quote['items']);
        $this->quoteDataRepository->updateQuote($this->quote);
    }
}
