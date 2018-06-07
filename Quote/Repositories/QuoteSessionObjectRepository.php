<?php

namespace Laragento\Quote\Repositories;

use Illuminate\Support\Facades\Auth;
use Laragento\Quote\DataObject\QuoteSessionObject;

class QuoteSessionObjectRepository
{

    protected $quote;

    public function __construct(QuoteSessionObject $quoteSessionObject)
    {
        $this->quote = $quoteSessionObject;
    }


    public function createQuote($storeId = null)

    {
        //ToDo hardcoded bachmann Keys
        if (!$storeId) {
            $storeKey = request()->get('store');
            $storeId = $storeKey == 'b2b' ? 1 : 2;
        }

        $this->destroyQuote();

        if (!$this->quote->getCartId()) {
            $this->quote->setCartId();
        }
        if (Auth::user() && !$this->quote->getCustomerId()) {
            $this->quote->setCustomerId(Auth::user()['entity_id']);
        }
        if (!$this->quote->getRemoteIp()) {
            $this->quote->setRemoteIp(request()->ip());
        }
        if (!$this->quote->getStoreId()) {
            $this->quote->setStoreId($storeId);
        }

        session()->put('laragento_cart', $this->quote);
        return $this->getQuote();

    }

    public function getQuote()
    {
        return session()->get('laragento_cart');
    }

    public function updateQuote($quoteData)
    {
        $quote = $this->getQuote();
        foreach ($quoteData as $key => $value) {
            $function = 'set' . str_replace(' ','',ucwords(str_replace('_', ' ', $key)));
            $quote->$function($value);
        }
        session()->put('laragento_cart', $quote);
        return $quote;

    }

    public function destroyQuote()
    {
        session()->forget('laragento_cart');
    }


}