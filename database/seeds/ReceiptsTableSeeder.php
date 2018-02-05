<?php

use Illuminate\Database\Seeder;
use App\Receipt;

class ReceiptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = \Faker\Factory::create();

		$n = 10;
        // Create receiptsrecords
        for ($i = 0; $i < $n; $i++) {
            Receipt::create([
                'user_id' => 2,
                'retailer_id' => $i + 1,
                'subtotal' => $faker->randomFloat(3, 0, 1000),
                'payment_method' => 'Cash - Card'
            ]);
        }
    }
}
