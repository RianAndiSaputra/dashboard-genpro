<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $companyUser = User::where('role', 'company')->first();

        // $companyUser = User::firstOrCreate(
        //     ['email' => 'company1@example.com'],
        //     [
        //         'username' => 'company1',
        //         'full_name' => 'PT. Digital Nusantara',
        //         'password' => Hash::make('password123'),
        //         'role' => 'company',
        //         'phone' => '081234567894'
        //     ]
        // );

        // // Kemudian buat data company
        // Company::firstOrCreate(
        //     ['user_id' => $companyUser->user_id],
        //     [
        //         'nama_perusahaan' => 'PT. Digital Nusantara',
        //         'email' => 'info@digitalnusantara.com',
        //         'nomor_wa' => '081234567894',
        //     ]
        // );

        // // Data perusahaan kedua
        // $companyUser2 = User::firstOrCreate(
        //     ['email' => 'company2@example.com'],
        //     [
        //         'username' => 'company2',
        //         'full_name' => 'PT. Teknologi Maju',
        //         'password' => Hash::make('password123'),
        //         'role' => 'company',
        //         'phone' => '081234567895'
        //     ]
        // );

        // Company::firstOrCreate(
        //     ['user_id' => $companyUser2->user_id],
        //     [
        //         'nama_perusahaan' => 'PT. Teknologi Maju',
        //         'email' => 'info@teknologimaju.com',
        //         'nomor_wa' => '081234567895',
        //     ]
        // );
    }
}
