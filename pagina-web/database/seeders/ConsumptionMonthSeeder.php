<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ConsumptionMonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('consumption_months')->insert([
            'consumo' => 5.500,
            'valor' => 23.10,
        ]);

        DB::table('consumption_months')->insert([
            'consumo' => 5.500,
            'valor' => 23.10,
        ]);

        DB::table('consumption_months')->insert([
            'consumo' => 5.500,
            'valor' => 23.10,
        ]);

        DB::table('consumption_months')->insert([
            'consumo' => 1.000,
            'valor' => 23.10,
        ]);
    }
}
