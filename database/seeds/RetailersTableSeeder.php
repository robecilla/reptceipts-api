<?php

use Illuminate\Database\Seeder;
use App\Retailer;

class RetailersTableSeeder extends Seeder
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
        // Create retailers records
        for ($i = 0; $i < $n; $i++) {
            Retailer::create([
                'name' => $faker->company,
                'address1' => $faker->streetName,
                'address2' => $faker->streetAddress,
                'address3' => $faker->city,
                'postcode' => $faker->postcode,
                'email' => $faker->safeEmail,
                'phone_number' => $faker->ean8,
                'mobile_number' => $faker->ean8
            ]);
        }
    }
}
