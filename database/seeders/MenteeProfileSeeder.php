<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Company;
use App\Models\MenteeProfile;

class MenteeProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    //     MenteeProfile::create([
    //         'user_id' => 1,
    //         'kelas_id' => 1,
    //         'company_id' => 1,
    //         'address' => 'Jl. Contoh No.123, Yogyakarta',
    //         'profile_picture' => 'profile1.jpg',
    //         'bidang_usaha' => 'Kuliner',
    //         'badan_hukum' => 'CV',
    //         'tahun_berdiri' => '2018',
    //         'jumlah_karyawan' => 10,
    //         'jumlah_omset' => 50000000,
    //         'jabatan' => 'CEO',
    //         'komitmen' => 'iya',
    //         'gambar_laporan' => 'laporan1.png',
    //     ]);

    //     // Tambahkan data lainnya kalau perlu
    }
}
