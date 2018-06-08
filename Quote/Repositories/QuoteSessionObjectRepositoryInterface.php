<?php

namespace Laragento\Quote\Repositories;

use Laragento\Quote\DataObject\QuoteSessionObject;


/**
 * Class QuoteSessionObjectRepository
 * @package Laragento\Quote\Repositories
 */
interface QuoteSessionObjectRepositoryInterface
{
    /**
     * Create the cart.
     *
     * @param int $storeId
     * @return QuoteSessionObject
     */
    public function createQuote($storeId = 0);

    /**
     * Get the cart.
     *
     * @return QuoteSessionObject
     */
    public function getQuote();

    /**
     * Update cart data.
     *
     * @param $quoteData
     * @return QuoteSessionObject
     */
    public function updateQuote($quoteData);

    /**
     * Destroy the cart.
     */
    public function destroyQuote();
}