<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hanya membuat user admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tokoku.com',
            'password' => Hash::make('admin123'), // Menggunakan Hash::make untuk mengenkripsi password dengan Bcrypt
            'role' => 'admin',
        ]);
        
        // User biasa akan membuat akun sendiri melalui form registrasi
    }
}
