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
                'title' => $faker->company,
                'body' => $faker->paragraph,
            ]);
        }
    }
}
