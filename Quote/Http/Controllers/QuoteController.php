<?php

namespace Laragento\Quote\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Quote\Repositories\QuoteSessionObjectRepository;

class QuoteController extends Controller
{
    protected $quoteDataRepository;

    /**
     * QuoteController constructor.
     */
    public function __construct(QuoteSessionObjectRepository $quoteDataRepository)
    {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->middleware('auth')->except([]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->quoteDataRepository->createQuote();
        $quote = session('laragento_cart');
        return view('quote::show', compact('quote'));
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        $quote = session('laragento_cart');
        return view('quote::show', compact('quote'));
    }


    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update()
    {
        $quoteData = request()->except('_method','_token');


        /* Only for Testin purposes */
        $quoteData['quote_currency_code'] ='EUR';
        /* Testing end */

        $oldQuote = session('laragento_cart');
        session()->put('laragento_cart',array_replace($oldQuote, $quoteData));
        $quote = session('laragento_cart');
        return view('quote::show', compact('quote'));

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
        session()->forget('laragento_cart');
        $quote = session('laragento_cart');
        return view('quote::show', compact('quote'));
    }
}
