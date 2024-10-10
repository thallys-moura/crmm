<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('billing_status')->insert([
            ['status' => 'Pago'],
            ['status' => 'Pago Parc.'],
            ['status' => 'Não Pagou'],
            ['status' => 'Cancelado'],
            ['status' => 'Pendente'],
        ]);
    }
}
