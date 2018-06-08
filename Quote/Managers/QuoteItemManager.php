<?php


namespace Laragento\Quote\Managers;


use Laragento\Quote\DataObject\QuoteSessionItem;
use Laragento\Quote\DataObject\QuoteSessionObject;
use Laragento\Quote\Repositories\QuoteSessionItemRepository;
use Laragento\Quote\Repositories\QuoteSessionItemRepositoryInterface;
use Laragento\Quote\Repositories\QuoteSessionObjectRepository;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;

class QuoteItemManager
{
    protected $quoteDataRepository;
    protected $quoteItemRepository;

    /**
     * QuoteController constructor.
     * @param QuoteSessionObjectRepositoryInterface $quoteDataRepository
     * @param QuoteSessionItemRepositoryInterface $quoteItemRepository
     */
    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository,
        QuoteSessionItemRepositoryInterface $quoteItemRepository
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
        $taxes = [
            'total' => []
        ];
        /** @var QuoteSessionItem $item */
        foreach ($quote->getItems() as $item) {
            array_push($prices, $item->getBaseRowTotalInclTax());
            $tax = $item->getBaseRowTotalInclTax() - $item->getBaseRowTotal();
            $strIndex = str_replace('.', '_', number_format($item->getTaxPercent(),2));
            $val = isset($taxes[$strIndex]) ? $taxes[$strIndex] : 0;
            $taxes[$item->getTaxPercent()] = $val + $tax;
            array_push($taxes['total'], $tax);
        }
        $grandTotalFull = array_sum($prices);
        $taxAmountFull = array_sum($taxes['total']);
        $subTotalFull = $grandTotalFull - $taxAmountFull;
        $grandTotal = number_format(round((($grandTotalFull +  0.000001) * 100 ) / 100 , 2),4);
        $taxes['total'] = number_format(round((($taxAmountFull +  0.000001) * 100 ) / 100 , 2),4);
        $subTotal = number_format(round((($subTotalFull +  0.000001) * 100 ) / 100 , 2),4);

        // ToDo if 5Rp round is needed
        //var_dump(round(($var + 0.000001) * 20) / 20,2);

        $quote->setGrandTotal($grandTotal);
        $quote->setSubtotal($subTotal);
        $quote->setSubtotalWithDiscount($subTotal);
        $quote->setBaseSubtotal($subTotal);
        $quote->setBaseSubtotalWithDiscount($subTotal);
        $quote->setTaxGroups($taxes);


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
        $this->calculateTotals($quote);

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