@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Yellow Card - Total Mentee -->
        <div class="bg-white rounded-lg shadow-md p-6 h-24 flex items-center">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4" style="background-color: #FFBF00;">
                <i data-lucide="users" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Total Mentee</h3>
                <p class="text-xl font-semibold">{{ $menteeCount }}</p>
            </div>
        </div>
        
        <!-- Pink Card - New Mentees -->
        <div class="bg-white rounded-lg shadow-md p-6 h-24 flex items-center">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4" style="background-color: #E3256B;">
                <i data-lucide="user-plus" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Mentee Baru Hari Ini</h3>
                <p class="text-xl font-semibold">{{ $newMentees }}</p>
            </div>
        </div>
    </div>

    <!-- Bottom Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Card 1 - Top Business -->
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-4" style="background-color: #E3256B;">
                <i data-lucide="briefcase" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-lg font-semibold mb-2">Bidang Usaha Terpopuler</h3>
            <p class="text-gray-600 text-sm">{{ $topBusiness ? $topBusiness->bidang_usaha : 'Belum ada data' }}</p>
            <div class="w-full h-0.5 bg-gray-100 mt-4 mb-3"></div>
            <p class="text-xs text-gray-500">{{ $topBusiness ? $topBusiness->total . ' mentee' : '' }}</p>
        </div>

        <!-- Card 2 - Class Count -->
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-4" style="background-color: #FFBF00;">
                <i data-lucide="book-open" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-lg font-semibold mb-2">Total Kelas</h3>
            <p class="text-gray-600 text-sm">{{ $classCount }} kelas</p>
            <div class="w-full h-0.5 bg-gray-100 mt-4 mb-3"></div>
            <p class="text-xs text-gray-500">{{ $activeClassCount }} kelas aktif</p>
        </div>

        <!-- Card 3 -->
        <!-- Card 3 - Mutabaah Stats -->
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-4" style="background-color: #8A2BE2;">
                <i data-lucide="bar-chart-2" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-lg font-semibold mb-2">Mutaba'ah</h3>
            <p class="text-gray-600 text-sm">{{ $mutabaahCount }} entri mutaba'ah</p>
            <div class="w-full h-0.5 bg-gray-100 mt-4 mb-3"></div>
            <p class="text-xs text-gray-500">{{ $uniqueMenteesWithMutabaah }} mentee sudah mengisi</p>
        </div>

                <!-- Card 4 -->
                <!-- Card 4 - Company Stats -->
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-4" style="background-color: #3498DB;">
                <i data-lucide="building-2" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-lg font-semibold mb-2">Perusahaan</h3>
            <p class="text-gray-600 text-sm">{{ $companyCount }} perusahaan terdaftar</p>
            <div class="w-full h-0.5 bg-gray-100 mt-4 mb-3"></div>
            <p class="text-xs text-gray-500">Lihat daftar perusahaan</p>
        </div>
    </div>
    <script>
        // Fungsi untuk menambahkan token ke semua request
        function addAuthTokenToRequests() {
            const originalFetch = window.fetch;
            
            window.fetch = async function(url, options = {}) {
                const token = localStorage.getItem('auth_token');
                
                if (token) {
                    options.headers = options.headers || {};
                    options.headers.Authorization = `Bearer ${token}`;
                }
                
                const response = await originalFetch(url, options);
                
                // Jika token tidak valid atau expired
                if (response.status === 401) {
                    localStorage.removeItem('auth_token');
                    window.location.href = '/';
                }
                
                return response;
            };
        }
        
        // Cek token saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('auth_token');
            
            if (!token) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sesi Berakhir',
                    text: 'Silakan login kembali',
                    confirmButtonColor: '#580720',
                }).then(() => {
                    window.location.href = '/';
                });
                return;
            }
            
            // Tambahkan token ke semua request
            addAuthTokenToRequests();
            
            // Logout handler
            document.getElementById('logout-button')?.addEventListener('click', async function() {
                try {
                    const response = await fetch('/logout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Authorization': `Bearer ${token}`
                        }
                    });
                    
                    if (response.ok) {
                        localStorage.removeItem('auth_token');
                        document.cookie = 'auth_token=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
                        
                        await Swal.fire({
                            icon: 'success',
                            title: 'Logout Berhasil',
                            text: 'Mengarahkan ke halaman login...',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        
                        window.location.href = '/';
                    } else {
                        throw new Error('Logout gagal');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Logout Gagal',
                        text: error.message,
                        confirmButtonColor: '#580720',
                    });
                }
            });
        });
    </script>
@endsection