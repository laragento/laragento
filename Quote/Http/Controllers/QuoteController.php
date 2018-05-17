<?php

namespace Laragento\Quote\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laragento\Quote\DataObject\QuoteSessionObject;

class QuoteController extends Controller
{
    /**
     * QuoteController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except([]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $quote = new QuoteSessionObject();
        return view('quote::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('quote::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('quote::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('quote::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
