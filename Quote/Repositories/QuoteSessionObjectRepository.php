<?php

namespace Laragento\Quote\Repositories;

use Laragento\Quote\DataObject\QuoteSessionObject;

class QuoteSessionObjectRepository
{
    protected $quote;

    public function __construct(QuoteSessionObject $quote)
    {

        $this->quote = $quote;
    }

    public function createQuote()
    {
        $cart = [];
        $cart['cart_id'] = request('cart_id');
        session()->put('laragento_cart', $cart);
    }

    public function getAllQuotes()
    {
        return session()->get('laragento_cart');
    }

    public function getQuote()
    {

    }

    public function updateQuote()
    {


    }

    public function destroyQuote()
    {


    }



}