<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        $jabatans = [
            ['nama_jabatan' => 'General Manager'],
            ['nama_jabatan' => 'Team Aktivasi'],
            ['nama_jabatan' => 'Team Pemeliharaan'],
            ['nama_jabatan' => 'Team Pemasaran'],
            ['nama_jabatan' => 'Team Administrasi'],
            ['nama_jabatan' => 'Team Pembangunan'],
            ['nama_jabatan' => 'Team Engineer'],
            ['nama_jabatan' => 'Team Retail'],
            ['nama_jabatan' => 'Team Opharset'],
        ];

        foreach ($jabatans as $jabatan) {
            DB::table('jabatans')->insert($jabatan);
        }
    }
}
