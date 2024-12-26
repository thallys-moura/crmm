<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FontesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('sources')->insert([
            ['name' => 'META ADS'],
            ['name' => 'GOOGLE ADS'],
            ['name' => 'OTHERS'],
        ]);
    }
}
