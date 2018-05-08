<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    protected $fillable = ['name', 'address1', 'address2', 'address3', 'postcode', 'email', 'phone_number', 'mobile_number'];
}
