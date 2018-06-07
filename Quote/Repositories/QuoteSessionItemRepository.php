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
        // Get and set Product
        $product = $this->productRepository::productBySku($data['sku']);
        $data['product_id'] = $product['entity_id'];


        // Set Price Information
        $totals = $this->setTotals($product->entity_id, $data['qty'], $data['store_id']);
        $data = array_merge($data, $totals);

        // Populate Item
        $quoteItem = new QuoteSessionItem();
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
        $newItem = null;
        $items = $this->get();
        /** @var QuoteSessionItem $item */
        foreach ($items as $item) {
            if ($item->getItemId() == $id) {
                $newItem = $item;
                break;
            }
        }
        // Set Price Information
        $totals = $this->setTotals($item->getProductId(),$data['qty'],$data['store_id']);
        $data = array_merge($data, $totals);

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

    /**
     * @param $data
     * @param $product
     * @return mixed
     */
    protected function setTotals($productId, $qty, $storeId)
    {
        $data = [];
        //ToDo Getting Tax from Config File: Must come from backend/Different TaxGroups
        $data['tax_percent'] = config('quote.totals.tax_percent');


        $data['base_price_incl_tax'] = ($val = $this->productAttributeRepository->data('price', $productId,
            $storeId)) ? $val->value : 0;
        $data['price_incl_tax'] = $data['base_price_incl_tax'];

        $taxAmount = $data['base_price_incl_tax'] * $data['tax_percent'] / 100;
        $data['base_tax_amount'] = number_format(round((($taxAmount + 0.000001) * 100) / 100, 2), 4);
        $data['tax_amount'] = $data['base_tax_amount'];

        $base_row_total_incl_tax = $qty * $data['base_price_incl_tax'];
        $data['base_row_total_incl_tax'] = number_format(round((($base_row_total_incl_tax + 0.000001) * 100) / 100, 2),
            4);
        $data['row_total_incl_tax'] = $data['base_row_total_incl_tax'];

        $base_price = $data['base_price_incl_tax'] - $taxAmount;
        $data['base_price'] = number_format(round((($base_price + 0.000001) * 100) / 100, 2), 4);
        $data['price'] = $data['base_price'];

        $base_row_total = $qty * $base_price;
        $data['base_row_total'] = number_format(round((($base_row_total + 0.000001) * 100) / 100, 2), 4);
        $data['row_total'] = $data['base_row_total'];
        return $data;
    }
}