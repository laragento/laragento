<?php

namespace Laragento\Quote\Repositories;

use Illuminate\Support\Facades\Auth;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;
use Laragento\Quote\DataObject\QuoteSessionItem;
use Laragento\Quote\DataObject\QuoteSessionObject;

class QuoteSessionItemRepository
{
    protected $quoteDataRepository;
    protected $productRepository;

    public function __construct(
        QuoteSessionObjectRepository $quoteDataRepository,
        ProductRepositoryInterface $productRepository
)
    {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->productRepository = $productRepository;

    }

    public function createItem($data)
    {
        $quoteItem = new QuoteSessionItem();
        $product = $this->productRepository->productBySku($data['sku']);
        $data['product'] = $product;
        $data['product_id'] = $product['entity_id'];
        foreach ($data as $key => $value) {
            $function = 'set' . str_replace(' ','',ucwords(str_replace('_', ' ', $key)));
            $quoteItem->$function($value);
        }
        return $quoteItem;

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

    public function bySku($sku)
    {
        $items = $this->get();
        foreach($items as $i) {
            if ($i->getSku() == $sku) {
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
        return $items;
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