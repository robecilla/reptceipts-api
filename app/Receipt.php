<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = ['user_id', 'retailer_id'];
    public $timestamps = false;

    public function retailer() {
        return $this->belongsTo('App\Retailer');    
    }

    public function receiptDetail() {
        return $this->hasOne('App\ReceiptDetail');    
    }
}
