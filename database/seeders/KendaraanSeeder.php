<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KendaraanSeeder extends Seeder
{
    public function run()
    {
        $tipeKendaraan = [
            'Xenia',
            'Avanza',
            'Rush',
            'Sigra',
            'Livina',
            'Terios',
            'Inova'
        ];

        foreach ($tipeKendaraan as $tipe) {
            for ($i = 1; $i <= 3; $i++) {
                DB::table('kendaraan')->insert([
                    'id' => Str::uuid(),
                    'nama' => $tipe,
                    'tipe' => $tipe,
                    'nomor_plat' => 'B ' . rand(1000, 9999) . ' ' . chr(rand(65, 90)) . chr(rand(65, 90)),
                    'stok' => rand(1, 5),
                    'total_kilometer' => rand(10000, 50000),
                    'image_url' => 'https://example.com/images/' . strtolower($tipe) . '.jpg',
                    'tarif_harian' => rand(300000, 800000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}