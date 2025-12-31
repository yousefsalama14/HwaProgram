<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class rollingnames extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('rollingnames')->insert([
            ['name' => 'الدرفلة فقط', 'operation_id' => 2, 'price' => 5, 'smallweight' => 25, 'lesspriceweight' => 30],
            ['name' => 'الدرفلة + لحام باسات', 'operation_id' => 2, 'price' => 5, 'smallweight' => 25, 'lesspriceweight' => 30],
            ['name' => 'الدرفلة + لحام كامل', 'operation_id' => 2, 'price' => 5, 'smallweight' => 25, 'lesspriceweight' => 30],
        ]);
    }
}
