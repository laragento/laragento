<?php

namespace Laragento\Quote\Http\Api;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Quote\Repositories\QuoteSessionItemRepository;
use Laragento\Quote\Repositories\QuoteSessionObjectRepository;

class QuoteItemApi extends Controller
{

    protected $quoteItemRepository;
    protected $quote;
    protected $quoteDataRepository;

    /**
     * QuoteController constructor.
     */
    public function __construct(QuoteSessionItemRepository $quoteItemRepository, QuoteSessionObjectRepository $quoteDataRepository)
    {
        $this->quoteItemRepository = $quoteItemRepository;
        $this->quoteDataRepository = $quoteDataRepository;
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
        $this->quote['items_count'] = count($this->quote['items']);
        $this->quote['items_qty'] = count($this->quote['items']);
        $this->quoteDataRepository->updateQuote($this->quote);

        return response()->json($item->toArray(),201);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function first($id)
    {
        $item = $this->quoteItemRepository->byId($id);
        return response()->json($item->toArray());
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function getByProduct($productId)
    {
        $item = $this->quoteItemRepository->byProductId($productId);
        return response()->json($item);
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
        $this->quoteItemRepository->destroyItem($itemId);
        return response()->json([],204);
    }
}
