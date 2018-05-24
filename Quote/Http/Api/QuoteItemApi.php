<?php

namespace Laragento\Quote\Http\Api;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Catalog\Repositories\Product\ProductRepository;
use Laragento\Catalog\Transformers\ChildProductTransformer;
use Laragento\Quote\DataObject\QuoteSessionObject;
use Laragento\Quote\Repositories\QuoteSessionItemRepository;
use Laragento\Quote\Repositories\QuoteSessionObjectRepository;
use Laragento\Quote\Transformers\QuoteItemTransformer;
use Spatie\Fractal\Fractal;

class QuoteItemApi extends Controller
{

    protected $quoteItemRepository;
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
        $this->middleware('auth')->except([]);
    }


    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store()
    {
        $itemData = request()->all();
        $quote = $this->quoteDataRepository->getQuote();
        $items = $quote->getItems();
        $lastItem = end($items);
        if ($lastItem) {
            $itemData['item_id'] = $lastItem->getItemId() + 1;
        } else {
            $itemData['item_id'] = 1;
        }
        $items[] = $this->quoteItemRepository->createItem($itemData);
        $this->settingQuoteItemsInfo($quote,$items);
        $fractal = Fractal::create(end($items), new QuoteItemTransformer());
        return response()->json($fractal,201);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function get()
    {
        return $this->quoteItemRepository->get();

    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function find($id)
    {
        $item = $this->quoteItemRepository->byId($id);
        $fractal = Fractal::create($item, new QuoteItemTransformer());
        return response()->json($fractal,200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function byProduct($productId)
    {
        $item = $this->quoteItemRepository->byProductId($productId);
        $fractal = Fractal::create($item, new QuoteItemTransformer());
        return response()->json($fractal,200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function productByItem($itemId)
    {
        $item = $this->quoteItemRepository->byId($itemId);
        $product = $this->productRepository->byId($item->getProductId());
        $fractal = Fractal::create($product, new ChildProductTransformer());
        return response()->json($fractal,200);
    }

    /**
     * Update the specified resource in storage.
     * @return Response
     */
    public function update($itemId)
    {
        $itemdata = request()->all();
        $item = $this->quoteItemRepository->updateItem($itemId, $itemdata);
        $fractal = Fractal::create($item, new QuoteItemTransformer());
        return response()->json($fractal,200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($itemId)
    {
        $items = $this->quoteItemRepository->destroyItem($itemId);
        $this->settingQuoteItemsInfo($this->quoteDataRepository->getQuote(), $items);

        return response()->json([],204);
    }


    /**
     * @param QuoteSessionObject $quote
     * @param $items
     */
    private function settingQuoteItemsInfo($quote,$items)
    {
        $quote->setItems($items);
        $quote->setItemsCount(count($items));
        $quote->setItemsQty(count($items));

        $this->quoteDataRepository->updateQuote($quote);
    }
}
