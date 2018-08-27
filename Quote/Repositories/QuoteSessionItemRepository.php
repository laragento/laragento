<?php

namespace Laragento\Quote\Repositories;

use Laragento\Catalog\Repositories\Product\ProductAttributeRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;
use Laragento\Quote\DataObjects\QuoteSessionItem;
use Laragento\Quote\DataObjects\QuoteSessionObject;

class QuoteSessionItemRepository implements QuoteSessionItemRepositoryInterface
{
    /**
     * @var QuoteSessionObjectRepositoryInterface
     */
    protected $quoteDataRepository;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var ProductAttributeRepositoryInterface
     */
    protected $productAttributeRepository;

    /**
     * QuoteSessionItemRepository constructor.
     *
     * @param QuoteSessionObjectRepositoryInterface $quoteDataRepository
     * @param ProductRepositoryInterface $productRepository
     * @param ProductAttributeRepositoryInterface $productAttributeRepository
     */
    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository,
        ProductRepositoryInterface $productRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository
    ) {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->productRepository = $productRepository;
        $this->productAttributeRepository = $productAttributeRepository;

    }

    /**
     * @inheritdoc
     * @ToDo Bases and Amounts are not regarding conversions
     */
    public function createItem($data)
    {
        // Get and set Product
        $product = $this->productRepository::productBySku($data['sku']);
        $data['product_id'] = $product->entity_id;
        $data['product_type'] = $product->type_id;
        $data['weight'] =  $this->getAttributeValue('weight', $product->entity_id);
        $data['name'] = $this->getAttributeValue('name', $product->entity_id);
        $data['description'] = $this->getAttributeValue('description', $product->entity_id);


        if (config('quote.calculateTotals')) {
            // Set Price Information
            $totals = $this->setTotals($product->entity_id, $data['qty'], $data['store_id']);
            $data = array_merge($data, $totals);
        }

        // Populate Item
        $quoteItem = new QuoteSessionItem();
        foreach ($data as $key => $value) {
            $function = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            $quoteItem->$function($value);
        }
        return $quoteItem;

    }

    /**
     * @inheritdoc
     */
    public function get(): array
    {
        return $this->quote()->getItems();
    }

    /**
     * @inheritdoc
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

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function updateItem($id, $data): array
    {
        // Find item
        $newItem = null;
        $items = $this->get();
        /** @var QuoteSessionItem $item */
        foreach ($items as $item) {
            if ($item->getItemId() == $id) {
                $newItem = $item;
                break;
            }
        }
        if (config('quote.calculateTotals')) {

            // Recalculate Totals
            $totals = $this->setTotals($item->getProductId(), $data['qty'], $data['store_id']);
            $data = array_merge($data, $totals);
        }

        // Set new item values
        foreach ($data as $key => $value) {
            $function = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            $newItem->$function($value);
        }
        return $items;
    }

    /**
     * @inheritdoc
     */
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

    /**
     * Get the cart.
     *
     * @return QuoteSessionObject
     */
    protected function quote()
    {
        return $this->quoteDataRepository->getQuote();
    }

    /**
     * Calculate item totals.
     *
     * @param $productId
     * @param $qty
     * @param $storeId
     * @return array
     */
    protected function setTotals($productId, $qty, $storeId): array
    {
        $data = [];
        //ToDo Now: Getting Tax from Config File: Must come from backend/Different TaxGroups
        $data['tax_percent'] = config('quote.totals.tax_percent');

        // Get item prices
        $specialPrice = $this->specialPrice($storeId,$productId);
        if($specialPrice != null)
        {
            $data['base_price_incl_tax'] = $specialPrice;
            $data['price_incl_tax'] = $data['base_price_incl_tax'];
        }else{
            $data['base_price_incl_tax'] = ($val = $this->productAttributeRepository->data('price', $productId,
                $storeId)) ? $val->value : 0;
        }

        $data['price_incl_tax'] = $data['base_price_incl_tax'];


        // Calculate item tax amounts
        $taxAmount = $data['base_price_incl_tax'] * $data['tax_percent'] / 100;
        $data['base_tax_amount'] = number_format(round((($taxAmount + 0.000001) * 100) / 100, 2), 4);
        $data['tax_amount'] = $data['base_tax_amount'];

        // Get row totals
        $base_row_total_incl_tax = $qty * $data['base_price_incl_tax'];
        $data['base_row_total_incl_tax'] = number_format(round((($base_row_total_incl_tax + 0.000001) * 100) / 100, 2),
            4);
        $data['row_total_incl_tax'] = $data['base_row_total_incl_tax'];

        // Calculate prices without taxes
        $base_price = $data['base_price_incl_tax'] - $taxAmount;
        $data['base_price'] = number_format(round((($base_price + 0.000001) * 100) / 100, 2), 4);
        $data['price'] = $data['base_price'];

        // Calculate row totals without taxes
        $base_row_total = $qty * $base_price;
        $data['base_row_total'] = number_format(round((($base_row_total + 0.000001) * 100) / 100, 2), 4);
        $data['row_total'] = $data['base_row_total'];

        return $data;
    }

    /**
     * @param $productId
     * @param $attribute
     * @return mixed
     */
    protected function getAttributeValue($attribute, $productId, $storeId = 0)
    {
        $attr = $this->productAttributeRepository->data($attribute,
            $productId, $storeId);
        return is_object($attr) ? $attr->value : '';
    }


    /**
     * @param $storeId
     * @param $productId
     * @return null
     */
    protected function specialPrice($storeId,$productId)
    {
        // @todo make less db queries!
        $specialPriceFrom = ($val = $this->productAttributeRepository->data('special_from_date', $productId,
            $storeId)) ? $val->value : null;
        $specialPriceTo = ($val = $this->productAttributeRepository->data('special_to_date', $productId,
            $storeId)) ? $val->value : null;

        $from = \Carbon\Carbon::parse($specialPriceFrom);
        $to = \Carbon\Carbon::parse($specialPriceTo);

        if(\Carbon\Carbon::create()->between($from, $to))
        {
            $specialPrice = ($val = $this->productAttributeRepository->data('special_price', $productId,
                $storeId)) ? $val->value : null;
            if( $specialPrice != null)
            {
                return $specialPrice;
            }
        }
        return null;
    }
}