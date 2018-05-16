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
        $quote = app()->make('Laragento\Quote\DataObject\QuoteSessionObject');

        if (!session()->exists('laragento_cart')) {
            session('laragento_cart', []);
        }
        dd($quote);
        session()->put('laragento_cart', $quote);
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