<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payments')->insert([
            ['method' => 'Dinheiro', 'created_at' => now(), 'updated_at' => now()],
            ['method' => 'Cartão de Crédito', 'created_at' => now(), 'updated_at' => now()],
            ['method' => 'Cartão de Débito', 'created_at' => now(), 'updated_at' => now()],
            ['method' => 'Boleto', 'created_at' => now(), 'updated_at' => now()],
            ['method' => 'Pix', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
