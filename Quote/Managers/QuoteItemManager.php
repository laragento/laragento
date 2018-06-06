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
     * @param QuoteSessionObject $quote
     */
    public function calculateTotals($quote)
    {
        $prices = [];
        foreach ($quote->getItems() as $item) {
            array_push($prices, $item->getPrice());
        }
        $grandTotalFull = array_sum($prices);
        $taxAmountFull = $grandTotalFull * 0.077;
        $subTotalFull = $grandTotalFull - $taxAmountFull;
        $grandTotal = number_format(round((($grandTotalFull +  0.000001) * 100 ) / 100 , 2));
        $taxAmount = number_format(round((($taxAmountFull +  0.000001) * 100 ) / 100 , 2));
        $subTotal = number_format(round((($subTotalFull +  0.000001) * 100 ) / 100 , 2));

        // ToDo if 5Rp round is needed
        //var_dump(round(($var + 0.000001) * 20) / 20,2);

        $quote->setGrandTotal($grandTotal);
        $quote->setSubtotal($subTotal);
        $quote->setSubtotalWithDiscount($subTotal);
        $quote->setBaseSubtotal($subTotal);
        $quote->setBaseSubtotalWithDiscount($subTotal);
        $quote->setTaxAmount($taxAmount);


        $this->quoteDataRepository->updateQuote($quote);
    }

    /**
     * @param $data
     * @param null $item
     */
    public function storeItems($data, $item = null): void
    {
        if (isset($data['sku'])) {
            $data = $this->storeItemData($data, $item);
        }
        $quote = $this->getQuote();
        $quote->setItems($data);
        $this->settingQuoteItemsInfo($quote);
        $this->calculateTotals($quote);
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