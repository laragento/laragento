<?php


namespace Laragento\Quote\Managers;


use Laragento\Quote\DataObjects\QuoteSessionItem;
use Laragento\Quote\DataObjects\QuoteSessionObject;
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
    ) {
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
        if (count($quote->getItems()) > 0) {
            $quote->setItemsQty(array_sum(array_column($quote->getItems(), 'qty')));
        } else {
            $quote->setItemsQty(0);
        }


        $this->quoteDataRepository->updateQuote($quote);
    }

    /**
     * @param QuoteSessionObject $quote
     */
    public function calculateTotals($quote)
    {
        $prices = [];
        $taxes = [
            'total' => [],
            'base_total' => []
        ];
        $totalWeight = 0.0000;

        // ToDo Must become abstracted as TaxRule/Calculation Module

        /** @var QuoteSessionItem $item */
        foreach ($quote->getItems() as $item) {
            array_push($prices, $item->getBaseRowTotalInclTax());
            $baseTax = $item->getBaseRowTotalInclTax() - $item->getBaseRowTotal();
            $tax = $item->getRowTotalInclTax() - $item->getRowTotal();
            $strIndex = str_replace('.', '_', number_format($item->getTaxPercent(), 2));
            $val = isset($taxes[$strIndex]) ? $taxes[$strIndex] : 0;
            $taxes[$strIndex] = (float)$val + (float)$tax;
            $item->setRowWeight(($item->getWeight() * $item->getQty()));
            $totalWeight = $totalWeight + ($item->getWeight()*$item->getQty());
            $taxes['base_total'] = $this->formatItemPrices($taxes[$strIndex]);
            $taxes['total'] = $this->convertBaseToQuote($taxes['base_total']);
        }
        $baseGrandTotalFull = array_sum($prices);
        $baseSubTotalFull = $baseGrandTotalFull - $taxes['base_total'];
        $baseGrandTotal = $this->formatItemPrices($baseGrandTotalFull);
        $baseSubTotal = $this->formatItemPrices($baseSubTotalFull);

        // ToDo if 5Rp round is needed
        //var_dump(round(($var + 0.000001) * 20) / 20,2);

        $quote->setGrandTotal($this->convertBaseToQuote($baseGrandTotal));
        $quote->setBaseGrandTotal($baseGrandTotal);
        $quote->setSubtotal($this->convertBaseToQuote($baseSubTotal));
        $quote->setSubtotalWithDiscount($this->convertBaseToQuote($baseSubTotal));
        $quote->setBaseSubtotal($baseSubTotal);
        $quote->setBaseSubtotalWithDiscount($baseSubTotal);
        $quote->setTaxGroups($taxes);
        $quote->setTotalWeight($totalWeight);


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

    protected function formatItemPrices($value)
    {
        return roundPrecicePrice($value, 1, 2, 4);
    }

    /**
     * @param $data
     * @param $rate
     * @return string
     */
    protected function convertBaseToQuote($value): string
    {
        $rate = $this->getQuote()->base_to_quote_rate;
        return $this->formatItemPrices($value * $rate);
    }

}