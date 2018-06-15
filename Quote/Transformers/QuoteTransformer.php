<?php

namespace Laragento\Quote\Transformers;

use Laragento\Quote\DataObjects\QuoteSessionObject;
use League\Fractal;

class QuoteTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = [
        'items',
        //'group'
    ];

    public function transform(QuoteSessionObject $quote)
    {

        return [
            'cart_id' => (string)$quote->getCartId(),
            'store_id' => (int)$quote->getStoreId(),
            'customer_id' => (int)$quote->getCustomerId(),
            'items_count' => (int)$quote->getItemsCount(),
            'items_qty' => (int)$quote->getItemsQty(),
            'quote_currency_code' => (string)$quote->getQuoteCurrencyCode(),
            'remote_ip' => (string)$quote->getRemoteIp(),
            'coupon_code' => (string)$quote->getCouponCode(),
            'grand_total' => (float)$quote->getGrandTotal(),
            'subtotal' => (float)$quote->getSubtotal(),
            'base_subtotal' => (float)$quote->getBaseSubtotal(),
            'subtotal_with_discount' => (float)$quote->getSubtotalWithDiscount(),
            'base_subtotal_with_discount' => (float)$quote->getBaseSubtotalWithDiscount()
        ];
    }

    public function includeItems(QuoteSessionObject $quote)
    {
        return $this->collection($quote->getItems(), new QuoteItemTransformer());
    }
}