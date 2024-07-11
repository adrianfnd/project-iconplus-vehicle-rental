<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DendaSeeder extends Seeder
{
    public function run()
    {
        DB::table('denda')->insert([
            [
                'jumlah_denda' => '50000',
                'description' => 'Denda 50000 per hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}