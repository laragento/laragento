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
     * @param QuoteSessionObjectRepository $quoteDataRepository
     */
    public function __construct(QuoteSessionObjectRepository $quoteDataRepository)
    {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->middleware('auth')->except([]);
    }

    /**
     * Display a listing of the resource.
     * @return void
     */
    public function index()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store($storeId)
    {
        $this->quoteDataRepository->createQuote($storeId);
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
     * @return Response
     */
    public function update($storeId)
    {
        $quoteData = request()->except('_method','_token');

        $quoteData['store_id'] = $storeId;

        $this->quoteDataRepository->updateQuote($quoteData);

        return redirect(route('quote.show'));

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
        $this->quoteDataRepository->destroyQuote();
        return redirect(route('quote.show'));
    }
}
