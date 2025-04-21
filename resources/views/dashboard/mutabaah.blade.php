@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <!-- Header -->
        <div class="bg-yellow-500 text-center py-3 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-bold text-gray-800">LAPORAN MUTABAAH</h2>
        </div>

        <!-- Form Fields - Horizontal layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="flex items-center">
                <label class="block w-24">Tahun</label>
                <span class="mr-2">:</span>
                <input type="text" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" value="2023">
            </div>
            <div class="flex items-center">
                <label class="block w-24">Bulan</label>
                <span class="mr-2">:</span>
                <select class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
        </div>
        <!-- Pagination and Export -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            <div class="flex items-center bg-gray-50 rounded-md px-3 py-2 shadow-sm w-full md:w-auto">
                <span class="mr-2 text-gray-600">Tampilkan</span>
                <select class="border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                <span class="ml-2 text-gray-600">entri</span>
            </div>
            <div class="flex items-center space-x-3 w-full md:w-auto">
                <button class="bg-red-900 hover:bg-gray-700 text-white px-4 py-2 rounded-md shadow transition duration-300 flex items-center">
                    <i data-lucide="file-text" class="w-4 h-4 mr-1"></i>
                    Ekspor
                </button>
                <div class="flex items-center bg-gray-50 rounded-md px-3 py-1 shadow-sm w-full">
                    <span class="mr-2 text-gray-600">Cari:</span>
                    <input type="text" class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-yellow-500 w-full">
                </div>
            </div>
        </div>

        <!-- Table with horizontal scrolling -->
        <div class="border border-gray-200 rounded-lg overflow-x-auto">
            <table class="min-w-max w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">No</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Nama</th>
                        <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Sholat<br>Jamaah</th>
                        <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Baca<br>Qur'an</th>
                        <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Sholat<br>Dhuha</th>
                        <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Puasa<br>Sunnah</th>
                        <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Sedekah<br>Subuh</th>
                        <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Relasi<br>Baru</th>
                        <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Menabung</th>
                        <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Penjualan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Row 1 -->
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 sticky left-0 bg-white">1</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 sticky left-12 bg-white">21/04/2023</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 sticky left-40 bg-white">Ahmad</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">TIDAK</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">TIDAK</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                    </tr>
                    
                    <!-- Row 2 -->
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 sticky left-0 bg-white">2</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 sticky left-12 bg-white">22/04/2023</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 sticky left-40 bg-white">Mentee 2</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">TIDAK</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">TIDAK</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">TIDAK</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                    </tr>
                    
                    <!-- Row 3 -->
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 sticky left-0 bg-white">3</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 sticky left-12 bg-white">23/04/2023</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 sticky left-40 bg-white">Mentee 3</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">TIDAK</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">TIDAK</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">TIDAK</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">IYA</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">TIDAK</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">TIDAK</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-4 bg-gray-50 px-4 py-3 rounded-lg">
            <div>
                <span class="text-sm text-gray-700">Menampilkan 1 sampai 3 dari 3 entri</span>
            </div>
            <div class="flex space-x-1">
                <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-md flex items-center justify-center transition duration-300">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Modal Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
    
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }
</script>
@endsection