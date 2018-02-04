<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptDetail extends Model
{
   protected $fillable = ['user_id', 'location', 'subtotal'];
}
