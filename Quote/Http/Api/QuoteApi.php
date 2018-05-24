<?php

namespace Laragento\Quote\Http\Api;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Quote\Transformers\QuoteTransformer;
use Laragento\Quote\Repositories\QuoteSessionObjectRepository;
use Spatie\Fractal\Fractal;

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
        $fractal = Fractal::create($quote, new QuoteTransformer());
        return response()->json($fractal,201);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function first()
    {
        $quote = $this->quoteDataRepository->getQuote();
        $fractal = Fractal::create($quote, new QuoteTransformer());
        return response()->json($fractal, 200);
    }

    /**
     * Update the specified resource in storage.
     * @return Response
     */
    public function update()
    {
        $quoteData = request()->all();
        $quote = $this->quoteDataRepository->updateQuote($quoteData);
        $fractal = Fractal::create($quote, new QuoteTransformer());
        return response()->json($fractal, 200);
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
