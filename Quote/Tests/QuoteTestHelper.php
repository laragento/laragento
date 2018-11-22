<?php


namespace Laragento\Quote\Tests;


use Laragento\Quote\Managers\QuoteItemManager;
use Laragento\Quote\Repositories\QuoteSessionItemRepositoryInterface;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;

class QuoteTestHelper
{
    /**
     * @var $quoteRepo QuoteSessionObjectRepositoryInterface
     */
    protected $quoteRepository;
    protected $quoteItemRepository;
    protected $quoteItemManager;

    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository,
        QuoteSessionItemRepositoryInterface $quoteItemRepository,
        QuoteItemManager $quoteItemManager
    ) {
        $this->quoteRepository = $quoteDataRepository;
        $this->quoteItemRepository = $quoteItemRepository;
        $this->quoteItemManager = $quoteItemManager;
    }

    /**
     * @param array $products
     * @return \Laragento\Quote\DataObjects\QuoteSessionObject
     * @throws \Exception
     */
    public function create($products = [])
    {
        $quote = $this->quoteRepository->createQuote();

        foreach ($products as $key => $product){
            $itemData =
                [
                    'sku' => $product->sku,
                    'qty' => 1,//random_int(1,10),
                    'store_id' => 0,
                ];
            $this->quoteItemManager->storeItems($itemData);
        }

        return $quote;
    }
}