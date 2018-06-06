<?php

namespace Laragento\Quote\Repositories;

use Illuminate\Support\Facades\Auth;
use Laragento\Catalog\Repositories\Product\ProductAttributeRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;
use Laragento\Quote\DataObject\QuoteSessionItem;
use Laragento\Quote\DataObject\QuoteSessionObject;

class QuoteSessionItemRepository
{
    protected $quoteDataRepository;
    protected $productRepository;
    protected $productAttributeRepository;

    public function __construct(
        QuoteSessionObjectRepository $quoteDataRepository,
        ProductRepositoryInterface $productRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository
    ) {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->productRepository = $productRepository;
        $this->productAttributeRepository = $productAttributeRepository;

    }

    public function createItem($data)
    {

        $quoteItem = new QuoteSessionItem();
        $product = $this->productRepository->product($data['sku']);
        $data['base_price'] = ($val = $this->productAttributeRepository->data('price', $product->entity_id, $this->quote()->getStoreId())) ? $val->value : 0;
        $data['price'] = $data['base_price'];

        $base_row_total = $data['qty'] * $data['base_price'];
        $data['base_row_total'] = number_format(round((($base_row_total + 0.000001) * 100) / 100, 2), 4);
        $data['row_total'] = $data['base_row_total'];

        $data['product_id'] = $product['entity_id'];
        // ToDo hardcoded Values


        // ToDo Don't like the full product here
        $data['product'] = $product;
        foreach ($data as $key => $value) {
            $function = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
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
        foreach ($items as $i) {
            if ($i->getItemId() == $id) {
                return $i;
            }
        }
        return null;
    }

    public function byProductId($productId)
    {
        $items = $this->get();
        foreach ($items as $i) {
            if ($i->getProductId() == $productId) {
                return $i;
            }
        }
        return null;
    }

    public function bySku($sku)
    {
        $items = $this->get();
        foreach ($items as $i) {
            if ($i->getSku() == $sku) {
                return $i;
            }
        }
        return null;
    }

    public function updateItem($id, $data)
    {
        $items = $this->get();
        foreach ($items as $i) {
            if ($i->getItemId() == $id) {
                $item = $i;
                break;
            }
        }
        foreach ($data as $key => $value) {
            $function = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            $item->$function($value);
        }
        return $items;
    }


    public function destroyItem($id)
    {
        $items = $this->get();
        $cnt = 0;
        foreach ($items as $i) {
            if ($i->getItemId() == $id) {
                unset($items[$cnt]);
                break;
            }
            $cnt++;
        }
        return array_values($items);
    }

    private function quote()
    {
        return $this->quoteDataRepository->getQuote();
    }
}