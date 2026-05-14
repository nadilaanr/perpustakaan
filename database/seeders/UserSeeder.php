<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun untuk Admin
        User::create([
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'password'  => Hash::make('admin123'), // Lebih aman pakai Hash::make
            'role'      => 'admin',
        ]);

        // 2. Akun untuk Petugas
        User::create([
            'name'      => 'Petugas Perpustakaan',
            'email'     => 'petugas@gmail.com',
            'password'  => Hash::make('petugas123'),
            'role'      => 'petugas',
        ]);

        // 3. Akun untuk Peminjam (User Biasa)
        User::create([
            'name'      => 'Peminjam',
            'email'     => 'peminjam@gmail.com',
            'password'  => Hash::make('peminjam123'),
            'role'      => 'peminjam',
        ]);
    }
}
