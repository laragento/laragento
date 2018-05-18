<?php

namespace Laragento\Quote\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Quote\Repositories\QuoteSessionItemRepository;
use Laragento\Quote\Repositories\QuoteSessionObjectRepository;

class QuoteItemController extends Controller
{
    protected $quoteItemRepository;

    /**
     * QuoteController constructor.
     */
    public function __construct(QuoteSessionItemRepository $quoteItemRepository)
    {
        $this->quoteItemRepository = $quoteItemRepository;
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
    public function store()
    {
        $itemData = request()->except(['_method', '_token']);
        $this->quoteItemRepository->createItem($itemData);
        return redirect()->route('quote.show');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //
    }


    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($itemId)
    {
        $itemData = request()->except('_method','_token');
        $this->quoteItemRepository->updateItem($itemId,$itemData);
        return redirect()->route('quote.show');

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($itemId)
    {
        $this->quoteItemRepository->destroyItem($itemId);
        return redirect()->route('quote.show');
    }
}
