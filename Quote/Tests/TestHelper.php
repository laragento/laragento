<?php


namespace Laragento\Quote\Tests;


use Laragento\Quote\Repositories\QuoteSessionItemRepositoryInterface;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;

class TestHelper
{
    /**
     * @var $quoteRepo QuoteSessionObjectRepositoryInterface
     */
    protected $quoteRepo;
    protected $quoteItemRepo;

    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository,
        QuoteSessionItemRepositoryInterface $quoteItemRepository
    ) {
        $this->quoteRepo = $quoteDataRepository;
        $this->quoteItemRepo = $quoteItemRepository;
    }

    public function createQuote()
    {
        // We have a quote with 3 items
        $quote = $this->quoteRepo->createQuote();
        $itemData = [
            [
                'item_id' => 1,
                'product_id' => 4,
                'sku' => '013757',
                'qty' => 1
            ],
            [
                'item_id' => 2,
                'product_id' => 12,
                'sku' => '007776',
                'qty' => 10
            ],
            [
                'item_id' => 3,
                'product_id' => 18,
                'sku' => '013168',
                'qty' => 5
            ]
        ];
        $items = $quote->getItems();
        foreach ($itemData as $data) {
            $items[] = $this->quoteItemRepo->createItem($data);
        }
        $quote->setItems($items);
        $quote->setItemsCount(count($items));
        $quote->setItemsQty(array_sum(array_column($items, 'qty')));
        $this->quoteRepo->updateQuote($quote);
    }
}