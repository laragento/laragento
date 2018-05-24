<?php

namespace Laragento\Quote\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Quote\DataObject\QuoteSessionItem;
use Laragento\Quote\DataObject\QuoteSessionObject;
use Laragento\Quote\Repositories\QuoteSessionItemRepository;
use Laragento\Quote\Repositories\QuoteSessionObjectRepository;

class QuoteItemController extends Controller
{
    protected $quoteItemRepository;
    protected $quoteDataRepository;

    /**
     * QuoteController constructor.
     * @param QuoteSessionItemRepository $quoteItemRepository
     * @param QuoteSessionObjectRepository $quoteDataRepository
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
        $items = $this->getQuote()->getItems();
        $item = null;

        for ($index = 0;$index < count($items);$index++) {

            if ($items[$index]->getProductId() == $requestData['product_id']) {
                $item = $this->quoteItemRepository->updateItem($items[$index]->getItemId(), $requestData);
                $items[$index] = $item;
                break;
            }
        }

        if (!$item) {
            // Set Create new Item
            $itemData = $this->setItemId($requestData);
            $item = $this->quoteItemRepository->createItem($itemData);

            // Store item in cart
            array_push($items, $item);
        }

        $this->storeItems($items);

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
        var_dump('Hittin');
        die();
        $requestData = request()->except(['_method', '_token']);

        // Update Item Data
        $items = $this->updateItemData($itemId, $requestData);

        // Store Data in Cart
        $this->storeItems($items);
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
        $this->storeItems($items);

        return redirect()->route('quote.show');
    }

    /**
     * @param QuoteSessionObject $quote
     */
    protected function settingQuoteItemsInfo($quote)
    {
        $quote->setItemsCount(count($quote->getItems()));
        $quote->setItemsQty(count($quote->getItems()));
        $this->quoteDataRepository->updateQuote($quote);
    }

    /**
     * @param $itemData
     * @return array
     */
    protected function setItemId($itemData): array
    {
        $items = $this->getQuote()->getItems();
        $lastItem = end($items);
        $itemData['item_id'] = $lastItem ? $lastItem->getItemId() + 1 : 1;

        return $itemData;
    }

    /**
     * @return mixed
     */
    protected function getQuote()
    {
        return $this->quoteDataRepository->getQuote();
    }

    /**
     *
     * @param $itemId
     * @param $requestData
     * @return array
     */
    protected function updateItemData($itemId, $requestData): array
    {
        $items = $this->getQuote()->getItems();
        $index = 0;
        foreach ($items as $item) {

            /** @var QuoteSessionItem $item */
            if ($item->getItemId() == $itemId) {
                $items[$index] = $this->quoteItemRepository->updateItem($itemId, $requestData);
            }
            $index++;
        }
        return $items;
    }

    /**
     * @param $items
     */
    protected function storeItems($items): void
    {
        $quote = $this->getQuote();
        $quote->setItems($items);
        $this->settingQuoteItemsInfo($quote);
    }

}
