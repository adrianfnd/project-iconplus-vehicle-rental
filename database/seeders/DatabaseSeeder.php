<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            VendorSeeder::class,
            UserSeeder::class,
            KendaraanSeeder::class,
            JabatanSeeder::class,
            DriverSeeder::class,
            DendaSeeder::class,
        ]);
    }
}
