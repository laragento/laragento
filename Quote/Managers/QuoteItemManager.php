<?php

namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionItem;
use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\Repositories\QuoteSessionItemRepositoryInterface;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;

class QuoteItemManager implements QuoteItemManagerInterface
{
    protected $quoteDataRepository;
    protected $quoteItemRepository;
    protected $cartTotals;
    protected $quoteManager;

    /**
     * QuoteItemManager constructor.
     * @param QuoteSessionObjectRepositoryInterface $quoteDataRepository
     * @param QuoteSessionItemRepositoryInterface $quoteItemRepository
     * @param QuoteManager $quoteManager
     */
    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository,
        QuoteSessionItemRepositoryInterface $quoteItemRepository,
        QuoteManager $quoteManager
    ) {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->quoteItemRepository = $quoteItemRepository;
        $this->quoteManager = $quoteManager;
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
        if (count($quote->getItems()) > 0) {
            $quote->setItemsQty(array_sum(array_column($quote->getItems(), 'qty')));
        } else {
            $quote->setItemsQty(0);
        }

        $this->quoteDataRepository->updateQuote($quote);
    }

    /**
     * @param $data
     * @param null $item
     */
    public function storeItems($data, $item = null): void
    {
        if (isset($data['sku'])) {
            $item = $this->quoteItemRepository->bySku($data['sku']);
            $data = $this->storeItemData($data, $item);
        }

        $quote = $this->getQuote();
        $quote->setItems($data);
        $this->settingQuoteItemsInfo($quote);

        if (config('quote.calculateTotals') == true) {
            $this->calculateTotals($quote);
        }
    }

    /**
     * @param $items
     */
    public function updateItems($items): void
    {
        $quote = $this->getQuote();
        $quote->setItems($items);
        $this->settingQuoteItemsInfo($quote);
        if (config('quote.calculateTotals') == true) {
            $this->calculateTotals($quote);
        }
    }

    public function storeItemData($data, $item)
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

    public function calculateTotals($quote)
    {
        $this->quoteManager->calculateTotals($quote);
    }
}