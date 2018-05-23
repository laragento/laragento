<?php

namespace Laragento\Quote\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Quote\Repositories\QuoteSessionItemRepository;
use Laragento\Quote\Repositories\QuoteSessionObjectRepository;

class QuoteItemController extends Controller
{
    protected $quoteItemRepository;
    protected $quoteDataRepository;

    /**
     * QuoteController constructor.
     */
    public function __construct(
        QuoteSessionItemRepository $quoteItemRepository,
        QuoteSessionObjectRepository $quoteDataRepository
)
    {
        $this->quoteItemRepository = $quoteItemRepository;
        $this->quoteDataRepository = $quoteDataRepository;

        $this->middleware('auth')->except([]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store()
    {
        $itemData = request()->except(['_method', '_token']);
        $quote = $this->quoteDataRepository->getQuote();
        $items = $quote['items'];
        $lastId = end($items);
        $itemData['item_id'] = $lastId ? $lastId : 1;

        $item = $this->quoteItemRepository->createItem($itemData);
        $items[] = $item->toArray();

        $quote['items'] = $items;
        $this->settingQuoteItemsInfo($quote);

        return redirect()->route('quote.show');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //
    }


    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($itemId)
    {
        $itemData = request()->except('_method','_token');
        $this->quoteItemRepository->updateItem($itemId,$itemData);
        $this->settingQuoteItemsInfo();
        return redirect()->route('quote.show');

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($itemId)
    {
        $this->quoteItemRepository->destroyItem($itemId);
        return redirect()->route('quote.show');
    }

    private function settingQuoteItemsInfo($quote)
    {
        $quote['items_count'] = count($quote['items']);
        $quote['items_qty'] = count($quote['items']);
        $this->quoteDataRepository->updateQuote($quote);
    }

    private function quote()
    {
        return $this->quoteDataRepository->getQuote();
    }
}
