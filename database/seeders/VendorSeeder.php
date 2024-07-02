<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VendorSeeder extends Seeder
{
    public function run()
    {
        $vendors = [
            'RAFA',
            'BUDI ASMORO',
            'JAHIDIN',
            'DENI DENASWARA',
            'JEFRI SISWANTO',
            'JOKO SUBEKTI'
        ];

        foreach ($vendors as $vendorName) {
            DB::table('vendor')->insert([
                'id' => Str::uuid(),
                'nama' => $vendorName,
                'alamat' => 'Alamat ' . $vendorName,
                'kontak' => '08' . rand(1000000000, 9999999999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}