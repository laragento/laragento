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
        //$products[] = factory(Product::class)->create();
        //$products[] = factory(Product::class)->create();
        //$products[] = factory(Product::class)->create();

        // We have a quote with 3 items
        $quote = $this->quoteRepo->createQuote();

        //foreach ($products as $key => $product){
            $itemData[] =
                [
                    'item_id' => 1,
                    'sku' => 3,
                    'qty' => random_int(1,10),
                    'store_id' => 0,
                ];
        $itemData[] =
            [
                'item_id' => 2,
                'sku' => 8,
                'qty' => random_int(1,10),
                'store_id' => 0,
            ];
        //}


        $items = $quote->getItems();
        foreach ($itemData as $data) {
            $items[] = $this->quoteItemRepo->createItem($data);
        }
        $quote->setItems($items);
        $quote->setItemsCount(count($items));
        $quote->setItemsQty(array_sum(array_column($items, 'qty')));
        $this->quoteRepo->updateQuote($quote);

        return $quote;
    }
}