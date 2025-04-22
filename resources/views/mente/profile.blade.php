@extends('layouts.app')
@section('content')
<div class="relative bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header - Yellow header that overlaps the white card -->
    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-3/4">
        <div class="bg-yellow-500 text-center py-3 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-user mr-2"></i> Profil Mentee Genpro
            </h2>
            <p class="text-gray-700 text-sm">Detail informasi bisnis dan profil mentee</p>
        </div>
    </div>
    
    <div class="mt-14">
        <!-- Foto Profil dan Info Utama -->
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 mb-8">
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/default-avatar.png') }}" alt="Foto Profil" class="w-32 h-32 rounded-full object-cover border-4 border-yellow-400 shadow-md">
                <div class="mt-3 text-center">
                    <h3 class="text-xl font-bold text-gray-800">John Doe</h3>
                    <span class="inline-block px-3 py-1 text-sm font-semibold text-white bg-green-500 rounded-full mt-2">
                        <i class="fas fa-check-circle mr-1"></i> Aktif
                    </span>
                </div>
            </div>
            
            <div class="flex-1 bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Bisnis</p>
                        <p class="text-lg font-medium text-gray-800">Doe Enterprises</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Bidang Usaha</p>
                        <p class="text-lg font-medium text-gray-800">Retail</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Badan Hukum</p>
                        <p class="text-lg font-medium text-gray-800">PT (Perseroan Terbatas)</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tahun Berdiri</p>
                        <p class="text-lg font-medium text-gray-800">2015</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Detil -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-info-circle mr-2"></i> Informasi Detail
                </h3>
            </div>
            
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Alamat Domisili</p>
                        <p class="text-base text-gray-800">Jl. Gatot Subroto No. 123, Jakarta Selatan, DKI Jakarta</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-base text-gray-800">john.doe@example.com</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jumlah Karyawan</p>
                        <p class="text-base text-gray-800">10 orang</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jabatan di Genpro</p>
                        <p class="text-base text-gray-800">CEO</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Komitmen Kehadiran</p>
                        <p class="text-base text-gray-800">
                            <span class="inline-flex items-center text-green-600">
                                <i class="fas fa-check-circle mr-2"></i> Berkomitmen hadir setiap bulan
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Bergabung Sejak</p>
                        <p class="text-base text-gray-800">3 Januari 2023</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Finansial -->
        <div class="mt-6 bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-chart-line mr-2"></i> Data Finansial
                </h3>
            </div>
            
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Omset</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pertumbuhan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-800">2021</td>
                                <td class="px-4 py-3 text-sm text-gray-800 text-right">Rp 750.000.000</td>
                                <td class="px-4 py-3 text-sm text-gray-800 text-right">-</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-800">2022</td>
                                <td class="px-4 py-3 text-sm text-gray-800 text-right">Rp 1.200.000.000</td>
                                <td class="px-4 py-3 text-sm text-green-600 text-right">+60%</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-800">2023</td>
                                <td class="px-4 py-3 text-sm text-gray-800 text-right">Rp 1.850.000.000</td>
                                <td class="px-4 py-3 text-sm text-green-600 text-right">+54.2%</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-800">2024 (YTD)</td>
                                <td class="px-4 py-3 text-sm text-gray-800 text-right">Rp 1.250.000.000</td>
                                <td class="px-4 py-3 text-sm text-gray-500 text-right">Proyeksi +20%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-file-alt mr-2"></i> Dokumen Finansial
                    </h4>
                    <div class="flex items-center">
                        <i class="fas fa-file-pdf text-red-500 text-xl mr-2"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Laporan_Keuangan_2023_2024.pdf</p>
                            <p class="text-xs text-gray-500">Diunggah pada 15 April 2024</p>
                        </div>
                        <a href="#" class="ml-auto text-blue-600 hover:text-blue-800">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Penilaian dan Progress -->
        <div class="mt-6 bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-star mr-2"></i> Progress Mastermind
                </h3>
            </div>
            
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-700">Kehadiran</h4>
                            <span class="text-lg font-bold text-green-600">85%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-green-600 h-2.5 rounded-full" style="width: 85%"></div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">17 dari 20 pertemuan</p>
                    </div>
                    
                    <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-700">Implementasi</h4>
                            <span class="text-lg font-bold text-blue-600">70%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 70%"></div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">7 dari 10 tugas diselesaikan</p>
                    </div>
                    
                    <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-700">Kontribusi</h4>
                            <span class="text-lg font-bold text-purple-600">90%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-purple-600 h-2.5 rounded-full" style="width: 90%"></div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Sangat aktif dalam diskusi</p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h4 class="font-medium text-gray-700 mb-2">Catatan Mentor:</h4>
                    <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-gray-700 italic">
                            "John menunjukkan kemajuan yang signifikan dalam mengimplementasikan strategi pemasaran digital. Perlu fokus lebih pada manajemen arus kas untuk pertumbuhan yang berkelanjutan."
                        </p>
                        <p class="mt-2 text-xs text-gray-500 text-right">- Bapak Ahmad, Mentor Genpro (Update: 10 April 2024)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-8 flex flex-col md:flex-row justify-between">
            <div>
                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition duration-300 flex items-center">
                    <i class="fas fa-trash mr-2"></i> Hapus Data
                </button>
            </div>
            <div class="flex space-x-3 mt-3 md:mt-0">
                <a href="#" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <a href="#" class="bg-[#580720] hover:bg-[#800020] text-white px-4 py-2 rounded-md transition duration-300">
                    <i class="fas fa-edit mr-2"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection