<?php

namespace App\Http\Controllers;

use App\Retailer;
use Illuminate\Http\Request;

class RetailerController extends Controller
{
    /**
     * Displays a listing of Retailers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'code' => 200,
            'response' => Retailer::all()
        ], 200);
    }

    /**
     * Stores a newly created Retailer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$retailer = Retailer::create([
            'name' => $request->name,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'address3' => $request->address3,
            'postcode' => $request->postcode,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'mobile_number' => $request->mobile_number,
        ]);

        return response()->json([
            'code' => 200,
            'response' => $retailer
        ], 200);

    }

    /**
     * Display a specified Retailer.
     *
     * @param  \App\Retailer  $retailer
     * @return \Illuminate\Http\Response
     */
    public function show(Retailer $retailer)
    {
        return response()->json([
            'code' => 200,
            'response' => compact('retailer')
        ], 200);
    }

    /**
     * Updates a Retailer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Retailer  $retailer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Retailer $retailer)
    {
        $retailer = Retailer::find($retailer->id);
        
        foreach ($request->all() as $key => $var) {
            if(!empty($var) && $key !== '_method') {
                $retailer->$key = $var;
            }
        }

        $retailer->save();

        return response()->json([
            'code' => 200,
            'response' => 'Updated successfully'
        ], 200);
    }

    /**
     * Removes a Retailer
     *
     * @param  \App\Retailer  $retailer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retailer $retailer)
    {
        $retailer->delete();
        return response()->json([
            'code' => 200,
            'response' => 'Deleted successfully'
        ], 200);
    }
}
