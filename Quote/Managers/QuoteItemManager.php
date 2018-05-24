<?php


namespace Laragento\Quote\Managers;


use Laragento\Quote\DataObject\QuoteSessionItem;
use Laragento\Quote\DataObject\QuoteSessionObject;
use Laragento\Quote\Repositories\QuoteSessionItemRepository;
use Laragento\Quote\Repositories\QuoteSessionObjectRepository;

class QuoteItemManager
{
    protected $quoteDataRepository;
    protected $quoteItemRepository;

    /**
     * QuoteController constructor.
     * @param QuoteSessionObjectRepository $quoteDataRepository
     * @param QuoteSessionItemRepository $quoteItemRepository
     */
    public function __construct(
        QuoteSessionObjectRepository $quoteDataRepository,
        QuoteSessionItemRepository $quoteItemRepository
    )
    {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->quoteItemRepository = $quoteItemRepository;
    }

    /**
     * @return QuoteSessionObject
     */
    public function getQuote()
    {
        return $this->quoteDataRepository->getQuote();
    }

    /**
     * @param $itemData
     * @return array
     */
    public function setItemId($itemData): array
    {
        $items = $this->getQuote()->getItems();
        $lastItem = end($items);
        $itemData['item_id'] = $lastItem ? $lastItem->getItemId() + 1 : 1;

        return $itemData;
    }

    /**
     * @param QuoteSessionObject $quote
     */
    public function settingQuoteItemsInfo($quote)
    {
        $quote->setItemsCount(count($quote->getItems()));
        $quote->setItemsQty(count($quote->getItems()));

        $this->quoteDataRepository->updateQuote($quote);
    }

    /**
     * @param $data
     * @param null $item
     */
    public function storeItems($data, $item = null): void
    {
        if (isset($data['product_id'])) {
            $data = $this->storeItemData($data, $item);
        }
        $quote = $this->getQuote();
        $quote->setItems($data);
        $this->settingQuoteItemsInfo($quote);

    }

    /**
     * @param $items
     */
    public function updateItems($items): void
    {
        $quote = $this->getQuote();
        $quote->setItems($items);
        $this->settingQuoteItemsInfo($quote);

    }

    public function storeItemData($data,$item)
    {
        /** @var QuoteSessionItem $item */
        if (!$item) {
            $items = $this->getQuote()->getItems();
            if (count($data) > 0) {
                // Set Create new Item
                $itemData = $this->setItemId($data);
                $item = $this->quoteItemRepository->createItem($itemData);
                // Store item
                array_push($items, $item);
            }
        } else {
            // Update Item Data
            $items = $this->quoteItemRepository->updateItem($item->getItemId(), $data);
        }

        return $items;
    }

}