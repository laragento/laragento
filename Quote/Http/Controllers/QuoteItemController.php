<?php

namespace Laragento\Quote\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Quote\Managers\QuoteItemManager;
use Laragento\Quote\Repositories\QuoteSessionItemRepositoryInterface;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;

class QuoteItemController extends Controller
{
    protected $quoteItemRepository;
    protected $manager;
    protected $quoteDataRepository;

    /**
     * QuoteController constructor.
     *
     * @param QuoteSessionObjectRepositoryInterface $quoteDataRepository
     * @param QuoteSessionItemRepositoryInterface $quoteItemRepository
     * @param QuoteItemManager $quoteItemManager
     */
    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository,
        QuoteSessionItemRepositoryInterface $quoteItemRepository,
        QuoteItemManager $quoteItemManager
    ) {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->quoteItemRepository = $quoteItemRepository;
        $this->manager = $quoteItemManager;

        $this->middleware('auth')->except([]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $storeId
     * @return Response
     */
    public function store($storeId)
    {
        $requestData = request()->except(['_method', '_token']);
        if (!$this->quoteDataRepository->getQuote()) {
            $this->quoteDataRepository->createQuote($storeId);
        }
        $requestData['store_id'] = $storeId;
        $item = $this->quoteItemRepository->bySku($requestData['sku']);;

        $this->manager->storeItems($requestData, $item);

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     *
     * @return void
     */
    public function show()
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param $storeId
     * @param $itemId
     * @return Response
     */
    public function update($storeId, $itemId)
    {
        $requestData = request()->except(['_method', '_token']);
        $requestData['store_id'] = $storeId;

        // Update Item Data
        $items = $this->quoteItemRepository->updateItem($itemId, $requestData);

        // Store Data in Cart
        $this->manager->storeItems($items);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $itemId
     * @return Response
     */
    public function destroy($itemId)
    {
        $items = $this->quoteItemRepository->destroyItem($itemId);
        $this->manager->storeItems($items);
        return redirect()->back();
    }
}
