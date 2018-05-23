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
        return redirect(route('quote.show'));
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        $quote = $this->quoteDataRepository->getQuote();
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

        $this->quoteDataRepository->updateQuote($quoteData);

        return redirect(route('quote.show'));

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
        session()->forget('laragento_cart');
        return redirect(route('quote.show'));
    }
}
