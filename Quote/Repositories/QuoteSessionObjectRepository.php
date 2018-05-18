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


    public function createQuote()
    {

        session()->forget('laragento_cart');

        if (!$this->quote->getCartId()) {
            $this->quote->setCartId();
        }
        if (Auth::user() && !$this->quote->getCustomerId()) {
            $this->quote->setCustomerId(Auth::user()['entity_id']);
        }
        if (!$this->quote->getRemoteIp()) {
            $this->quote->setRemoteIp(request()->ip());
        }

        session()->put('laragento_cart', $this->quote->toArray());
    }

    public function getQuote()
    {
        return session()->get('laragento_cart');
    }

    public function updateQuote($quote)
    {
        session()->put('laragento_cart', $quote);
        return session()->get('laragento_cart');

    }

    public function destroyQuote()
    {
        session()->forget('laragento_cart');
    }


}