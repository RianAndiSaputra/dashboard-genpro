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
        // Admin
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'tanggal_lahir' => '23-08-2003',
            'full_name' => 'Administrator',
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // Mentor
        User::create([
            'username' => 'mentor1',
            'email' => 'mentor1@example.com',
            'password' => Hash::make('password123'),
            'tanggal_lahir' => '23-08-2003',
            'full_name' => 'Mentor Pertama',
            'role' => 'mentor',
            'phone' => '081234567891',
        ]);

        // Secretary
        User::create([
            'username' => 'sekretaris1',
            'email' => 'sekretaris@example.com',
            'password' => Hash::make('password123'),
            'tanggal_lahir' => '23-08-2003',
            'full_name' => 'Sekretaris Pertama',
            'role' => 'secretary',
            'phone' => '081234567892',
        ]);

        // Mentee
        User::create([
            'username' => 'mentee1',
            'email' => 'mentee1@example.com',
            'password' => Hash::make('password123'),
            'tanggal_lahir' => '23-08-2003',
            'full_name' => 'Mentee Pertama',
            'role' => 'mentee',
            'phone' => '081234567893',
        ]);

        // Company
        User::create([
            'username' => 'company1',
            'email' => 'company1@example.com',
            'password' => Hash::make('password123'),
            'tanggal_lahir' => '23-08-2003',
            'full_name' => 'Perusahaan Pertama',
            'role' => 'company',
            'phone' => '081234567894',
        ]);
    }
}
