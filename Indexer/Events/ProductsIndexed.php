<?php

namespace Laragento\Indexer\Events;

use Illuminate\Queue\SerializesModels;

class ProductsIndexed
{
    use SerializesModels;

    public $productIndexes;

    /**
     * Create a new event instance.
     *
     * @param $productIndexes
     * @return void
     */
    public function __construct($productIndexes)
    {
        $this->productIndexes = $productIndexes;
    }
}