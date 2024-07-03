<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = DB::table('vendor')->get();

        $vendorUsers = [];
        foreach ($vendors as $vendor) {
            $vendorUsers[] = [
                'id' => Str::uuid(),
                'name' => $vendor->nama,
                'email' => Str::slug($vendor->nama) . '@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => 4,
                'vendor_id' => $vendor->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('users')->insert($vendorUsers);

        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Staff Pemeliharaan dan Aset',
                'email' => 'staff.pemeliharaan@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Staff Fasilitas',
                'email' => 'staff.fasilitas@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Staff Admin',
                'email' => 'staff.admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
