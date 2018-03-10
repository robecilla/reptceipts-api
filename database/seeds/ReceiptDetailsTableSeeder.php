<?php

use Illuminate\Database\Seeder;
use App\ReceiptDetail;

class ReceiptDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Creates an array of n items
        $items = array();
        for ($j=0; $j < 3 ; $j++) { 
            $items[] = array(
                'name' => $faker->lastName,
                'quantity' => $faker->numberBetween($min = 0, $max = 5), 
                'price' => $faker->randomFloat(2, 0, 1000), 
                'serial_no' => $faker->bankAccountNumber
            );
        }

        $payments = ['VISA', 'MasterCard', 'Cash'];
		$n = 25;
        // Create receipts records
        for ($i = 0; $i < $n; $i++) {
            ReceiptDetail::create([
                'receipt_id' => $i + 1,
                'items' => json_encode($items),
                'subtotal' => $faker->randomFloat(2, 0, 1000),
                'payment_method' => $payments[mt_rand(0, count($payments) - 1)],
                'VAT' => $faker->numberBetween(10,99)
            ]);
        }
    }
}
