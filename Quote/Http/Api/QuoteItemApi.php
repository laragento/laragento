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
        $item = $this->quoteItemRepository->createItem($itemData);
        $this->quote['items'][] = $item;
        $this->quote['items_count'] = count($this->quote['items']);
        $this->quote['items_qty'] = count($this->quote['items']);
        $this->quoteDataRepository->updateQuote($this->quote);
        print_r($item);
        print_r($this->quote);

        return response()->json($item,201);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function first($id)
    {
        $item = $this->quoteItemRepository->byId($id);
        return response()->json($item);
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
    public function update($id)
    {
        $itemdata = request()->all();
        $item = $this->quoteItemRepository->updateItem($id, $itemdata);
        return response()->json($item);
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
