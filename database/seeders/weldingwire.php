<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class weldingwire extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('weldingwires')->insert([
            [
            'size' => 2.5,
            'price' => 50,
            ],
            [
            'size' => 3,
            'price' => 100,
            ],
            [
            'size' => 4,
            'price' => 150,
            ],
              ]
        );
    }
}
