<?php

namespace Laragento\Quote\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Quote\Managers\QuoteItemManager;
use Laragento\Quote\Repositories\QuoteSessionItemRepository;

class QuoteItemController extends Controller
{
    protected $quoteItemRepository;
    protected $manager;

    /**
     * QuoteController constructor.
     * @param QuoteSessionItemRepository $quoteItemRepository
     * @param QuoteItemManager $quoteItemManager
     */
    public function __construct(
        QuoteSessionItemRepository $quoteItemRepository,
        QuoteItemManager $quoteItemManager
    ) {
        $this->quoteItemRepository = $quoteItemRepository;
        $this->manager = $quoteItemManager;

        $this->middleware('auth')->except([]);
    }

    /**
     * Display a listing of the resource.
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store()
    {
        $requestData = request()->except(['_method', '_token']);

        $item = $this->quoteItemRepository->byProductId($requestData['product_id']);;

        $this->manager->storeItems($requestData,$item);

        return redirect()->route('quote.show');
    }

    /**
     * Show the specified resource.
     * @return void
     */
    public function show()
    {
        //
    }


    /**
     * Update the specified resource in storage.
     * @param $itemId
     * @return Response
     */
    public function update($itemId)
    {
        $requestData = request()->except(['_method', '_token']);

        // Update Item Data
        $items = $this->quoteItemRepository->updateItem($itemId, $requestData);

        // Store Data in Cart
        $this->manager->storeItems($items);
        return redirect()->route('quote.show');

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

        return redirect()->route('quote.show');
    }
}
