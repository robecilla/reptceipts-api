<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

Route::get('/', function() {
   return File::get(base_path() . '/frontpage/public/index.html');
});