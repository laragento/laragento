<?php

namespace Laragento\Quote\Http\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class QuoteApi extends Controller
{


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
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return response()->json([]);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function first()
    {
        return response()->json([]);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
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
