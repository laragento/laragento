<?php

namespace Laragento\Quote\Repositories;

use Illuminate\Support\Facades\Auth;
use Laragento\Quote\DataObjects\QuoteSessionObject;

class QuoteSessionObjectRepository implements QuoteSessionObjectRepositoryInterface
{

    /**
     * @var QuoteSessionObject
     */
    protected $quote;

    /**
     * QuoteSessionObjectRepository constructor.
     *
     * @param QuoteSessionObject $quoteSessionObject
     */
    public function __construct(QuoteSessionObject $quoteSessionObject)
    {
        $this->quote = $quoteSessionObject;
    }

    /**
     * @inheritdoc
     */
    public function createQuote($storeId = 0)
    {
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

    /**
     * @inheritdoc
     */
    public function getQuote()
    {
        return session()->get('laragento_cart');
    }

    /**
     * @inheritdoc
     */
    public function updateQuote($quoteData)
    {
        $quote = $this->getQuote();
        foreach ($quoteData as $key => $value) {
            $function = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            $quote->$function($value);
        }
        session()->put('laragento_cart', $quote);
        return $quote;
    }

    /**
     * @inheritdoc
     */
    public function destroyQuote()
    {
        session()->forget('laragento_cart');
    }


}