<?php

namespace Laragento\Quote\Repositories;

use Laragento\Catalog\Repositories\Product\ProductAttributeRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;
use Laragento\Quote\DataObject\QuoteSessionItem;

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

    /**
     * @ToDo Bases and Amounts are not regarding conversions
     *
     * @param $data
     * @return QuoteSessionItem
     *
     */
    public function createItem($data)
    {

        $quoteItem = new QuoteSessionItem();
        $product = $this->productRepository->product($data['sku']);

        // Set Price Information
        // ToDo Hardcoded Bachmann-Only Tax
        $data['tax_percent'] = 7.7000;

        $data['base_price_incl_tax'] = ($val = $this->productAttributeRepository->data('price', $product->entity_id, $this->quote()->getStoreId())) ? $val->value : 0;
        $data['price_incl_tax'] = $data['base_price_incl_tax'];

        $taxAmount = $data['base_price_incl_tax'] * $data['tax_percent'] / 100;
        $data['base_tax_amount'] = number_format(round((($taxAmount +  0.000001) * 100 ) / 100 , 2),4);
        $data['tax_amount'] = $data['base_tax_amount'];

        $base_row_total = $data['qty'] * $data['base_price_incl_tax'];
        $data['base_row_total'] = number_format(round((($base_row_total + 0.000001) * 100) / 100, 2), 4);
        $data['row_total'] = $data['base_row_total'];

        $base_price = $data['base_price_incl_tax'] - $data['tax_amount'];
        $data['base_price'] = number_format(round((($base_price + 0.000001) * 100) / 100, 2), 4);
        $data['price'] = $data['base_price'];

        $data['product_id'] = $product['entity_id'];

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

    /**
     * @param $id
     * @return null
     */
    public function byId($id)
    {
        $items = $this->get();

        /** @var QuoteSessionItem $item */
        foreach ($items as $item) {
            if ($item->getItemId() == $id) {
                return $item;
            }
        }
        return null;
    }

    public function byProductId($productId)
    {
        $items = $this->get();
        /** @var QuoteSessionItem $item */
        foreach ($items as $item) {
            if ($item->getProductId() == $productId) {
                return $item;
            }
        }
        return null;
    }

    public function bySku($sku)
    {
        $items = $this->get();
        /** @var QuoteSessionItem $item */
        foreach ($items as $item) {
            if ($item->getSku() == $sku) {
                return $item;
            }
        }
        return null;
    }

    public function updateItem($id, $data)
    {
        $items = $this->get();
        /** @var QuoteSessionItem $item */
        foreach ($items as $item) {
            if ($item->getItemId() == $id) {
                $newItem =  $item;
                break;
            }
        }

        foreach ($data as $key => $value) {
            $function = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            $newItem->$function($value);
        }
        return $items;
    }


    public function destroyItem($id)
    {
        $items = $this->get();
        $index = 0;
        /** @var QuoteSessionItem $item */
        foreach ($items as $item) {
            if ($item->getItemId() == $id) {
                unset($items[$index]);
                break;
            }
            $index++;
        }
        return array_values($items);
    }

    private function quote()
    {
        return $this->quoteDataRepository->getQuote();
    }
}