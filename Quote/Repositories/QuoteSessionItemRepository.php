<?php

namespace Laragento\Quote\Repositories;

use Illuminate\Support\Facades\Auth;
use Laragento\Quote\DataObject\QuoteSessionItem;
use Laragento\Quote\DataObject\QuoteSessionObject;

class QuoteSessionItemRepository
{

    protected $quoteItem;
    protected $quoteDataRepository;

    public function __construct(
        QuoteSessionObjectRepository $quoteDataRepository,
        QuoteSessionItem $quoteSessionItem
)
    {
        $this->quoteItem = $quoteSessionItem;
        $this->quoteDataRepository = $quoteDataRepository;

    }

    public function createItem($data)
    {
        foreach ($data as $key => $value) {
            $function = 'set' . str_replace(' ','',ucwords(str_replace('_', ' ', $key)));
            $this->quoteItem->$function($value);
        }
        return $this->quoteItem;

    }

    public function get()
    {
        return $this->quote()->getItems();
    }

    public function byId($id)
    {
        $items = $this->get();
        foreach($items as $i) {
            if ($i->getItemId() == $id) {
                return $i;
            }
        }
        return null;
    }

    public function byProductId($productId)
    {
        $items = $this->get();
        foreach($items as $i) {
            if ($i->getProductId() == $productId) {
                return $i;
            }
        }
        return null;
    }

    public function updateItem($id,$data)
    {
        $items = $this->get();
        foreach($items as $i) {
            if ($i->getItemId() == $id) {
                $item = $i;
                break;
            }
        }
        foreach ($data as $key => $value) {
            $function = 'set' . str_replace(' ','',ucwords(str_replace('_', ' ', $key)));
            $item->$function($value);
        }
        return $item;
    }


    public function destroyItem($id)
    {
        $items = $this->get();
        $cnt = 0;
        foreach($items as $i) {
            if ($i->getItemId() == $id) {
                unset($items[$cnt]);
                break;
            }
            $cnt++;
        }
        return array_values($items);
    }

    private function quote() {
        return $this->quoteDataRepository->getQuote();
    }
}