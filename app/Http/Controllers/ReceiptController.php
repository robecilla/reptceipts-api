<?php

namespace App\Http\Controllers;

use App\Receipt;
use App\User;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Display a generic listing of receipts.
     * Returns only receipts attached to a particular user from their JWT.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = auth()->user();
        $receipts = User::find($user->id)->receipts;

        return response()->json($receipts, 201);
    }

     /**
     * Display specific list of receipts based on the web-client requirement.
     * Returns only receipts attached to a particular user from their JWT.
     * @return \Illuminate\Http\Response
     */
    public function getReceipt()
    {
        $user = auth()->user();
        $receipts = User::find($user->id)->receipts->toArray();

        foreach ($receipts as $key => $receipt) {
            // Just getting the name here
            $receipts[$key]['retailer_name'] = Receipt::find($receipt['retailer_id'])->retailer->name;
        }

        return response()->json($receipts, 201);
    }

     /**
     * Gets extra receipt information via id.
     * Returns only receipts attached to a particular user from their JWT.
     * @return \Illuminate\Http\Response
     */
    public function getDetail(Request $request)
    {
        $receipt_id = $request->id;
        $detail = Receipt::find($receipt_id)->receiptDetail;

        return response()->json($detail, 201);
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
