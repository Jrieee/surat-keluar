<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SuratKeluar;
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
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@surat-app.test',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Create Pegawai Users
        $pegawai1 = User::factory()->create([
            'name' => 'Pegawai Satu',
            'email' => 'pegawai1@surat-app.test',
            'password' => bcrypt('password123'),
            'role' => 'pegawai',
        ]);

        $pegawai2 = User::factory()->create([
            'name' => 'Pegawai Dua',
            'email' => 'pegawai2@surat-app.test',
            'password' => bcrypt('password123'),
            'role' => 'pegawai',
        ]);

        // Create Sample Surat Keluars
        $surats = [
            [
                'nomor_surat' => '001/SK/2025',
                'tanggal_surat' => now()->subDays(5),
                'tujuan' => 'PT. ABC Indonesia',
                'perihal' => 'Permintaan Penawaran Harga',
                'alamat_penerima' => 'Jl. Merdeka No. 123, Jakarta Pusat 12345',
                'user_id' => $pegawai1->id,
            ],
            [
                'nomor_surat' => '002/SK/2025',
                'tanggal_surat' => now()->subDays(3),
                'tujuan' => 'CV. Maju Jaya',
                'perihal' => 'Konfirmasi Pesanan',
                'alamat_penerima' => 'Jl. Sudirman No. 456, Jakarta Selatan 12789',
                'user_id' => $pegawai2->id,
            ],
            [
                'nomor_surat' => '003/SK/2025',
                'tanggal_surat' => now()->subDays(1),
                'tujuan' => 'PT. Sejahtera Makmur',
                'perihal' => 'Undangan Meeting Bisnis',
                'alamat_penerima' => 'Jl. Gatot Subroto No. 789, Jakarta Barat 13456',
                'user_id' => $pegawai1->id,
            ],
        ];

        foreach ($surats as $surat) {
            SuratKeluar::create($surat);
        }
    }
}
