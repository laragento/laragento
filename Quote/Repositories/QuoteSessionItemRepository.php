<?php

namespace Laragento\Quote\Repositories;

use Illuminate\Support\Facades\Auth;
use Laragento\Quote\DataObject\QuoteSessionItem;
use Laragento\Quote\DataObject\QuoteSessionObject;

class QuoteSessionItemRepository
{

    protected $quoteItem;
    protected $quote;

    public function __construct(QuoteSessionItem $quoteSessionItem)
    {
        $this->quoteItem = $quoteSessionItem;
        $this->quote = session('laragento_quote');
    }

    public function createItem($data)
    {
        foreach ($data as $key => $value) {
            $function = 'set' . str_replace(' ','',ucwords(str_replace('_', ' ', $key)));
            $this->quoteItem->$function($value);
        }
        return $this->quoteItem;

    }

    public function byId($id)
    {
        return [];
    }

    public function byProductId($productId)
    {
        return [];
    }

    public function updateItem($id,$data)
    {
        return [];
    }


    public function destroyItem($id)
    {
        return [];
    }
}