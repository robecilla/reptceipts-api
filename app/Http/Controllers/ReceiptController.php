<?php

namespace App\Http\Controllers;

use App\Receipt;
use App\ReceiptDetail;
use App\User;
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
        
        foreach ($receipts as $key => $receipt) {
            $receipts[$key]['retailer_name'] = Receipt::find($receipt['id'])->retailer->name;
            $receipts[$key]['subtotal'] = Receipt::find($receipt['id'])->receiptDetail->subtotal;
        }

        return response()->json($receipts, 201);
    }

    /**
     * Creates a new receipt record.
     * Structure example:
     * 
     *  [
     *      {
     *          "user": 1,
     *          "retailer": 2,
     *          "items":[
     *                   {
     *                       "name": "item1",
     *                       "price": 12,
     *                       "quantity": 1,
     *                       "serial_no": 76936078
     *                   },
     *                   {
     *                       "name": "item2",
     *                       "price": 673.43,
     *                       "quantity": 1,
     *                       "serial_no": 43158526
     *                   },
     *                   {       
     *                       "name": "item3",
     *                       "price": 193.71,
     *                       "quantity": 5,
     *                       "serial_no": 32735161341820
     *                   }
     *                  ],
     *          "payment": "visa",
     *          "vat": 21
     *    }
     *  ]
     * 
     * The total is calculated iterating over the array of item objects and 
     * dynamically adding item prices to the total.
     * 
     * The subtotal is calculated by applyting the VAT over the total.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->calculateTotals($request->items, $request->vat);

		// Creates a receipt
		$receipt = Receipt::create([
            'user_id' => $request->user,
            'retailer_id' => $request->retailer
        ]);
        
        // Creates its detail
        $detail = ReceiptDetail::create([
            'receipt_id' => $receipt->id,
            'items' => $request->items,
            'total' => round($this->total, 2),
            'subtotal' => round($this->subtotal, 2),
            'payment_method' => $request->payment,
            'VAT' => round($this->vat_value, 2),
            'VAT_value' => $request->vat
        ]);

        return response()->json('Created successfully', 201);
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
        $detail['retailer'] = Receipt::find($receipt->id)->retailer;
        $detail['receipt'] = $receipt->receiptDetail;
        // receipt footer information
        // $detail['footer_info'] = $receipt->footer; or smnth like that

        return response()->json($detail, 201);
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

        return response()->json(null, 204);
    }
}
