<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        $jabatans = [
            ['id' => Str::uuid(), 'nama_jabatan' => 'General Manager'],
            ['id' => Str::uuid(), 'nama_jabatan' => 'Team Aktivasi'],
            ['id' => Str::uuid(), 'nama_jabatan' => 'Team Pemeliharaan'],
            ['id' => Str::uuid(), 'nama_jabatan' => 'Team Pemasaran'],
            ['id' => Str::uuid(), 'nama_jabatan' => 'Team Administrasi'],
            ['id' => Str::uuid(), 'nama_jabatan' => 'Team Pembangunan'],
            ['id' => Str::uuid(), 'nama_jabatan' => 'Team Engineer'],
            ['id' => Str::uuid(), 'nama_jabatan' => 'Team Retail'],
            ['id' => Str::uuid(), 'nama_jabatan' => 'Team Opharset'],
        ];

        foreach ($jabatans as $jabatan) {
            DB::table('jabatan')->insert($jabatan);
        }
    }
}
