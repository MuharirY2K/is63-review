<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@simahaswa.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'), // WAJIB di-hash!
            ]
        );


        $this->command->info('UserSeeder: Akun admin berhasil dibuat.');
        $this->command->info('Login: admin@simahaswa.com | password123');
    }
}
