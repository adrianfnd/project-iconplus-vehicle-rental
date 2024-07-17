<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = [
            [
                'id' => Str::uuid(),
                'nama' => 'John Doe',
                'alamat' => 'Jl. Merdeka No. 123, Bandung',
                'kontak' => '081234567890',
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Jane Smith',
                'alamat' => 'Jl. Sudirman No. 456, Jakarta',
                'kontak' => '087654321098',
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Bob Johnson',
                'alamat' => 'Jl. Diponegoro No. 789, Surabaya',
                'kontak' => '082198765432',
            ],
        ];

        foreach ($drivers as $driver) {
            DB::table('driver')->insert([
                'id' => $driver['id'],
                'nama' => $driver['nama'],
                'alamat' => $driver['alamat'],
                'kontak' => $driver['kontak'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}