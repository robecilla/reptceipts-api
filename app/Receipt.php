<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = ['user_id', 'retailer_id', 'subtotal', 'payment_method'];

    public function retailer() {
        return $this->belongsTo('App\Retailer');    
    }

    public function receiptDetail() {
        return $this->hasOne('App\ReceiptDetail');    
    }
}
