<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;


class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('months')->insert([
            'nome' => 'Janeiro',
            'consumption_months_id' => 1,
        ]);

        DB::table('months')->insert([
            'nome' => 'Fevereiro',
            'consumption_months_id' => 2,
        ]);

        DB::table('months')->insert([
            'nome' => 'Março',
            'consumption_months_id' => 3,
        ]);

        DB::table('months')->insert([
            'nome' => 'Abril',
            'consumption_months_id' => 4,
        ]);

        DB::table('months')->insert([
            'nome' => 'Maio'
        ]);

        DB::table('months')->insert([
            'nome' => 'Junho'
        ]);

        DB::table('months')->insert([
            'nome' => 'Julho'
        ]);

        DB::table('months')->insert([
            'nome' => 'Agosto'
        ]);

        DB::table('months')->insert([
            'nome' => 'Setembro'
        ]);

        DB::table('months')->insert([
            'nome' => 'Outubro'
        ]);

        DB::table('months')->insert([
            'nome' => 'Novembro'
        ]);

         DB::table('months')->insert([
            'nome' => 'Dezembro'
        ]);
    }
}
