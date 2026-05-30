<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Create Pegawai User 1
        User::factory()->create([
            'name' => 'Pegawai Satu',
            'username' => 'pegawai1',
            'password' => bcrypt('password123'),
            'role' => 'pegawai',
        ]);

        // Create Pegawai User 2
        User::factory()->create([
            'name' => 'Pegawai Dua',
            'username' => 'pegawai2',
            'password' => bcrypt('password123'),
            'role' => 'pegawai',
        ]);
    }
}