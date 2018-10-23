<?php

namespace Laragento\Quote\Transformers;

use Laragento\Quote\DataObjects\QuoteSessionItem;
use League\Fractal;

class QuoteItemTransformer extends Fractal\TransformerAbstract
{


    public function transform(QuoteSessionItem $quoteItem)
    {

        return [
            'item_id' => (int)$quoteItem->getItemId(),
            'product_id' => (int)$quoteItem->getProductId(),
            'qty' => (int)$quoteItem->getQty(),
            'sku' => (string)$quoteItem->getSku(),
            'price' => (float)$quoteItem->getPrice(),
            'base_price' => (float)$quoteItem->getBasePrice(),
            'custom_price' => (float)$quoteItem->getCustomPrice(),
            'discount_percent' => (float)$quoteItem->getDiscountPercent(),
            'discount_amount' => (float)$quoteItem->getDiscountAmount(),
            'tax_percent' => (float)$quoteItem->getTaxPercent(),
            'tax_amount' => (float)$quoteItem->getTaxAmount(),
            'row_total' => (float)$quoteItem->getRowTotal(),
            'row_total_with_discount' => (float)$quoteItem->getRowTotalWithDiscount(),
            'tax_before_discount' => (float)$quoteItem->getTaxBeforeDiscount(),
            'price_incl_tax' => (float)$quoteItem->getPriceInclTax(),
            'row_total_incl_tax' => (float)$quoteItem->getRowTotalInclTax(),
            'discount_tax_compensation_amount' => (float)$quoteItem->getDiscountTaxCompensationAmount(),
            'free_shipping' => (boolean)$quoteItem->getFreeShipping(),
        ];
    }
}