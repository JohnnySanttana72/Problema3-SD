<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class Log extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('logs')->insert([
            'id' => 1 
        ]);
    }
}
