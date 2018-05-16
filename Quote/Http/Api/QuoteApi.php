<?php

namespace Laragento\Quote\Http\Api;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Quote\Repositories\QuoteSessionObjectRepository;

class QuoteApi extends Controller
{

    protected $quoteDataRepository;

    /**
     * QuoteApi constructor.
     * @param QuoteSessionObjectRepository $quoteDataRepository
     */
    public function __construct(QuoteSessionObjectRepository $quoteDataRepository)
    {
        $this->middleware('auth')->except([]);
        $this->quoteDataRepository = $quoteDataRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function get()
    {
        return response()->json([]);
    }


    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store()
    {
        $this->quoteDataRepository->createQuote();
        return response()->json([]);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function first()
    {
        $quote = $this->quoteDataRepository->getQuote();
        return response()->json($quote);
    }

    /**
     * Update the specified resource in storage.
     * @return Response
     */
    public function update()
    {
        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
        return response()->json([]);
    }
}
