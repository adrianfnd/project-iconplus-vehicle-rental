<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'pemeliharaan', 'description' => 'role staff pemeliharaan aset'],
            ['name' => 'fasilitas', 'description' => 'role staff fasilitas'],
            ['name' => 'admin', 'description' => 'role staff admin'],
            ['name' => 'vendor', 'description' => 'role vendor penyedia'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }
    }
}
