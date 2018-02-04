<?php

namespace App\Http\Controllers;

use App\Receipt;
use App\User;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = auth()->user();
        $receipts = User::find($user->id)->receipts->toArray();

        foreach ($receipts as $key => $receipt) {
            $receipts[$key]['retailer'] = Receipt::find($receipt['retailer_id'])->retailer->name;
        }
        
        return response()->json($receipts, 201);
        //return response()->json($receipts, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// Creates a receipt
		$receipt = Receipt::create($request->all());
        return response()->json($receipt, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        return $receipt;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receipt $receipt)
    {
		$receipt->update($request->all());
        return response()->json($receipt, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
		$receipt->delete();
        return response()->json(null, 204);
    }
}
