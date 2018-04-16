<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_details', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('receipt_id');
            $table->json('items');
            $table->decimal('total');
            $table->decimal('subtotal');
            $table->string('payment_method');
            $table->decimal('VAT');
            $table->smallInteger('VAT_value');
            $table->smallInteger('scan_type');
            $table->boolean('is_redeemable');
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_details');
    }
}
