<?php

namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionObject;

interface QuoteItemManagerInterface
{

    /**
     * @return QuoteSessionObject
     */
    public function getQuote();

    /**
     * @param $itemData
     * @return array
     */
    public function setItemId($itemData);

    /**
     * @param QuoteSessionObject $quote
     */
    public function settingQuoteItemsInfo($quote);

    /**
     * @param $data
     * @param null $item
     */
    public function storeItems($data, $item = null);

    /**
     * @param $items
     */
    public function updateItems($items);

    public function storeItemData($data, $item);

    public function calculateTotals($quote);
}