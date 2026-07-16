<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,        // tidak bergantung tabel lain

            // Urutan ini WAJIB diikuti karena adanya foreign key:
            // 1. Prodi dulu (tidak bergantung pada tabel lain)
            // 2. Mahasiswa (bergantung pada prodi)
            // 3. Nilai (bergantung pada mahasiswa)
            ProdiSeeder::class,
            MahasiswaSeeder::class,
            NilaiSeeder::class,
        ]);
    }
}
