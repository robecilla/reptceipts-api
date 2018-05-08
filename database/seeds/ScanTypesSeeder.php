<?php

use Illuminate\Database\Seeder;

class ScanTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('scan_types')->insert([
            'scan_type' => 'QR',
        ]);

        DB::table('scan_types')->insert([
            'scan_type' => 'NFC',
        ]);
    }
}
