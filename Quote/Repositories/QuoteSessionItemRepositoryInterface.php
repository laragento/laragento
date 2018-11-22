<?php

namespace Laragento\Quote\Repositories;

use Laragento\Quote\DataObjects\QuoteSessionItem;


/**
 * Class QuoteSessionItemRepository
 * @package Laragento\Quote\Repositories
 */
interface QuoteSessionItemRepositoryInterface
{
    /**
     * Creates a cart Item.
     *
     * @param $data
     * @return QuoteSessionItem
     *
     */
    public function createItem($data);

    /**
     * Gets all cart items.
     *
     * @return array
     */
    public function get(): array;

    /**
     * Finds a cart item by ItemId.
     *
     * @param $id
     * @return QuoteSessionItem|null
     */
    public function byId($id);

    /**
     * Finds a cart item by ProductId.
     *
     * @param $productId
     * @return QuoteSessionItem|null
     */
    public function byProductId($productId);

    /**
     * Finds a cart item by Sku.
     *
     * @param $sku
     * @return QuoteSessionItem|null
     */
    public function bySku($sku);

    /**
     * Updates a specific cart item.
     *
     * @param $id
     * @param $data
     * @return array
     */
    public function updateItem($id, $data): array;

    /**
     * Destroys a specific cart item.
     *
     * @param $id
     * @return array
     */
    public function destroyItem($id);
}