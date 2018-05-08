<?php

namespace App\Http\Controllers;

use App\Receipt;
use App\ReceiptDetail;
use App\User;
use App\Retailer;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{

    private $total = 0;
    private $subtotal = 0;
    private $vat_value = 0;

    /**
     * Display a generic listing of receipts.
     * Returns only receipts attached to a particular user from their JWT.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = auth()->user();
        $receipts = User::find($user->id)->receipts;
        
        return response()->json([
            'code' => 200,
            'response' => $this->buildReceiptList($receipts)
        ], 200);
    }

    public function getReceiptsByUserID(Request $request)
    {
        try {
            $receipts = User::find($request->user_id)->receipts;
        } catch(\Exception $e) {
            return response()->json([
                'code' => 404,
                'response' => 'User not found',
            ], 404);
        }
        
        return response()->json([
            'code' => 200,
            'response' => $this->buildReceiptList($receipts)
        ], 200);
    }

    private function buildReceiptList($receipts) {
        foreach ($receipts as $key => $receipt) {
            $receipts[$key]['retailer_name'] = Receipt::find($receipt['id'])->retailer->name;
            $receipts[$key]['subtotal'] = Receipt::find($receipt['id'])->receiptDetail->subtotal;
            $receipts[$key]['is_redeemable'] = Receipt::find($receipt['id'])->receiptDetail->is_redeemable;
        }

        return $receipts;
    }

    /**
     * Creates a new receipt record.
     * 
     * The total is calculated iterating over the array of item objects and 
     * dynamically adding item prices to the total.
     * 
     * The subtotal is calculated by applying the VAT over the total.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $user = User::find($request->user_id);

            if(!$user) {
                return response()->json([
                    'code' => 404,
                    'response' => 'User not found'
                ], 404);
            }

            $retailer = Retailer::find($request->retailer);

            $this->calculateTotals($request->items, $request->vat);

            // Creates a receipt
            $receipt = Receipt::create([
                'user_id' => $user->id,
                'retailer_id' => $retailer->id
            ]);
            
            // Creates its detail
            $detail = ReceiptDetail::create([
                'receipt_id' => $receipt->id,
                'items' => $request->items,
                'total' => round($this->total, 2),
                'subtotal' => round($this->subtotal, 2),
                'payment_method' => $request->payment,
                'VAT' => round($this->vat_value, 2),
                'VAT_value' => $request->vat,
                'scan_type' => $request->scan_type,
                'is_redeemable' => $request->is_redeemable
            ]);

        } catch(\Exception $e) {
            return response()->json([
                'code' => 404,
                'response' => $e->getMessage(),
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'response' => 'Created successfully'
        ], 200);
    }

    /**
     * Calculates receipt totals given an array of items and VAT percentage.
     * @return \Illuminate\Http\Response
     */
    private function calculateTotals($items, $vat)
    {
        $items = json_decode($items);

        foreach ($items as $key => $item) {
            $this->total += ($item->price * $item->quantity);
        }

        $this->vat_value = ($vat / 100) * $this->total;
        $this->subtotal = $this->total + $this->vat_value ;
    }

     /**
     * Gets extra receipt information via id.
     * Returns only receipts attached to a particular user from their JWT.
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        $currentUser = auth()->user();
        $receiptUser = Receipt::find($receipt->id)->user;

        if($currentUser->id !==  $receiptUser->id) {
            return response()->json([
                'code' => 401,
                'response' => 'Receipt does not belong to user'
            ], 401);
        }

        $detail['retailer'] = Receipt::find($receipt->id)->retailer;
        $detail['receipt'] = $receipt->receiptDetail;

        return response()->json([
            'code' => 200,
            'response' => $detail
        ], 200);
    }

    /**
     * Removes Receipt and ReceiptDetail.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
        // Find its detail via Receipt ID
        $detail = ReceiptDetail::find($receipt->id);

        // Deletes both receipt and detail
        $receipt->delete();
        $detail->delete();

        return response()->json([
            'code' => 200,
            'response' => 'Deleted successfully'
        ], 200);
    }
}
