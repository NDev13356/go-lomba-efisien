<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Kandidat;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PilketosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
        ]);

        // Create Kandidat
        Kandidat::insert([
            [
                'nama' => 'Ahmad Fajar Maulana',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Aminah Putri',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create Siswa
        $siswaData = [
            ['nisn' => '1234567890', 'nama' => 'Andi Pratama'],
            ['nisn' => '1234567891', 'nama' => 'Bintang Wijaya'],
            ['nisn' => '1234567892', 'nama' => 'Citra Dewi'],
            ['nisn' => '1234567893', 'nama' => 'Dian Permata'],
            ['nisn' => '1234567894', 'nama' => 'Eka Putra'],
        ];

        foreach ($siswaData as $data) {
            Siswa::create([
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'password' => Hash::make('siswa'),
            ]);
        }

        $this->command->info('Seeder berhasil dijalankan!');
        $this->command->info('');
        $this->command->info('=== DATA LOGIN ===');
        $this->command->info('Admin: username=admin, password=admin');
        $this->command->info('Siswa: NISN=1234567890, password=siswa');
    }
}
