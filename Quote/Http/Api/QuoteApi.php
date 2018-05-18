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
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store()
    {
        $quote = $this->quoteDataRepository->createQuote();
        return response()->json($quote,201);
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
        $quoteData = request()->all();
        $quote = $this->quoteDataRepository->updateQuote($quoteData);
        return response()->json($quote);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
        $this->quoteDataRepository->destroyQuote();
        return response()->json([],204);
    }
}
