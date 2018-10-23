<?php

namespace Laragento\Indexer\Events;

use Illuminate\Queue\SerializesModels;

class CategoriesIndexed
{
    use SerializesModels;

    public $categoryIndexes;

    /**
     * Create a new event instance.
     *
     * @param $categoryIndexes
     * @return void
     */
    public function __construct($categoryIndexes)
    {
        $this->categoryIndexes = $categoryIndexes;
    }
}