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
        return $this->quote()['items'];
    }

    public function byId($id)
    {
        $items = $this->get();
        foreach($items as $i) {
            if ($i['item_id'] == $id) {
                return $i;
            }
        }
        return null;
    }

    public function byProductId($productId)
    {
        $items = $this->get();
        foreach($items as $i) {
            if ($i['product_id'] == $productId) {
                return $i;
            }
        }
        return null;
    }

    public function updateItem($id,$data)
    {
        $items = $this->get();
        foreach($items as $i) {
            if ($i['item_id'] == $id) {
                $item = $i;
                break;
            }
        }
        foreach ($data as $key => $value) {
            $item['key'] = $value;
        }
        return $item;
    }


    public function destroyItem($id)
    {
        $items = $this->get();
        $cnt = 0;
        foreach($items as $i) {
            if ($i['item_id'] == $id) {
                unset($items[$cnt]);
               array_values($items);
                break;
            }
            $cnt++;
        }
        return $items;
    }

    private function quote() {
        return $this->quoteDataRepository->getQuote();
    }
}