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

		$n = 25;
        // Create receiptsrecords
        for ($i = 0; $i < $n; $i++) {
            Receipt::create([
                'user_id' => 1,
                'retailer_id' => $i + 1
            ]);
        }
    }
}
