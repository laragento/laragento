<?php

namespace Laragento\Indexer\Handlers;

interface IndexHandlerInterface
{
    /**
     * @param $productId
     * @param $productRepository
     */
    public static function execute($productId, $productRepository);
}