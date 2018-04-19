<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptDetail extends Model
{
   protected $fillable = ['receipt_id', 'items', 'total', 'subtotal', 'payment_method', 'VAT', 'VAT_value', 'scan_type', 'is_redeemable'];

    // public function receipt() {
    //     return $this->hasOne('App\Receipt');    
    // }
}
