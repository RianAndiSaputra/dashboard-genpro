@extends('layouts.app')

@section('content')
<div class="relative bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header -->
    <div class="bg-yellow-500 text-center py-3 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Semua Kelas</h2> 
    </div>
    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="scheduled">Dijadwalkan</option>
                    <option value="completed">Selesai</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="">Semua Kategori</option>
                    <option value="online">Online</option>
                    <option value="offline">Tatap Muka</option>
                    <option value="hybrid">Hybrid</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div class="flex items-end">
                <button class="bg-red-900 hover:bg-red-900 text-white px-4 py-2 rounded-md shadow transition duration-300 w-full">
                    Filter
                </button>
            </div>
        </div>
    </div>
    <button onclick="openAddModal()" class="bg-red-900 hover:bg-yellow-600 text-white px-4 py-2 rounded-md shadow transition duration-300 flex items-center">
        <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
        Tambah Kelas Baru
    </button>
    <br>
    <!-- Kelas Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Kelas Card 1 -->
        <div class="bg-white rounded-lg shadow-xl hover:shadow-2xl transition-shadow duration-300 overflow-hidden border border-black-50 border-l-4 border-l-yellow-500">
            <div class="p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Kelas Tahsin Al-Qur'an</h3>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-red-900 text-white mb-2">Online</span>
                    </div>
                    <div class="dropdown relative">
                        <button class="text-gray-500 hover:text-gray-700">
                            <i data-lucide="more-vertical" class="w-5 h-5"></i>
                        </button>
                        <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden border border-gray-200">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="openEditModal()">Edit</a>
                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" onclick="confirmDelete()">Hapus</a>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                        <span>15 Apr - 15 Jun 2023</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                        <span>19:00 - 21:00 WIB</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="link" class="w-4 h-4 mr-2"></i>
                        <a href="#" class="text-red-900 hover:underline">zoom.us/j/123456789</a>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                        <span>25 Peserta</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                        <span>Ust. Ahmad Fauzi</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">Aktif</span>
                    <button onclick="openManageModal()" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium flex items-center">
                        <i data-lucide="settings" class="w-4 h-4 mr-1"></i>
                        Kelola Kelas
                    </button>
                </div>
            </div>
        </div>
    
        <!-- Kelas Card 2 -->
        <div class="bg-white rounded-lg shadow-xl hover:shadow-2xl transition-shadow duration-300 overflow-hidden border border-black-500 border-l-4 border-l-red-900">
            <div class="p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Kelas Bahasa Arab Dasar</h3>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 mb-2 border border-purple-200">Tatap Muka</span>
                    </div>
                    <div class="dropdown relative">
                        <button class="text-gray-500 hover:text-gray-700">
                            <i data-lucide="more-vertical" class="w-5 h-5"></i>
                        </button>
                        <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden border border-gray-200">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="openEditModal()">Edit</a>
                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" onclick="confirmDelete()">Hapus</a>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                        <span>1 Mei - 30 Jun 2023</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                        <span>16:00 - 18:00 WIB</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i>
                        <span>Masjid Al-Ikhlas, Jakarta</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                        <span>15 Peserta</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                        <span>Ust. Muhammad Ali</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">Dijadwalkan</span>
                    <button onclick="openManageModal()" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium flex items-center">
                        <i data-lucide="settings" class="w-4 h-4 mr-1"></i>
                        Kelola Kelas
                    </button>
                </div>
            </div>
        </div>
    
        <!-- Kelas Card 3 -->
        <div class="bg-white rounded-lg shadow-xl hover:shadow-2xl transition-shadow duration-300 overflow-hidden border border-black-500 border-l-4 border-l-green-500">
            <div class="p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Kelas Tahfidz Anak</h3>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800 mb-2 border border-orange-200">Hybrid</span>
                    </div>
                    <div class="dropdown relative">
                        <button class="text-gray-500 hover:text-gray-700">
                            <i data-lucide="more-vertical" class="w-5 h-5"></i>
                        </button>
                        <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden border border-gray-200">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="openEditModal()">Edit</a>
                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" onclick="confirmDelete()">Hapus</a>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                        <span>10 Mar - 10 May 2023</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                        <span>13:00 - 15:00 WIB</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i>
                        <span>Pondok Pesantren Al-Qur'an / Zoom</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                        <span>30 Peserta</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                        <span>Ust. Abdullah Mahmud</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-200">Selesai</span>
                    <button onclick="openManageModal()" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium flex items-center">
                        <i data-lucide="settings" class="w-4 h-4 mr-1"></i>
                        Kelola Kelas
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="flex justify-between items-center mt-6 bg-white px-4 py-3 rounded-lg shadow-md">
        <div>
            <span class="text-sm text-gray-700">Menampilkan 1 sampai 3 dari 10 entri</span>
        </div>
        <div class="flex space-x-1">
            <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-md flex items-center justify-center transition duration-300">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </button>
            <button class="bg-red-900 text-white px-3 py-1 rounded-md">1</button>
            <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-md">2</button>
            <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-md">3</button>
            <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-md flex items-center justify-center transition duration-300">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal Tambah Kelas -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">Tambah Kelas Baru</h3>
            <button onclick="closeAddModal()" class="text-gray-500 hover:text-gray-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6">
            <form>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="online">Online</option>
                            <option value="offline">Tatap Muka</option>
                            <option value="hybrid">Hybrid</option>
                        </select>
                    </div>
                    
                    <div id="lokasiOfflineField">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan lokasi kelas">
                    </div>
                    
                    <div id="linkOnlineField" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link Meeting</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan link Zoom/Meet">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                        <input type="time" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                        <input type="time" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pemateri/Coach</label>
                        <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="">Pilih Pemateri</option>
                            <option value="1">Ust. Ahmad Fauzi</option>
                            <option value="2">Ust. Muhammad Ali</option>
                            <option value="3">Ust. Abdullah Mahmud</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kuota Peserta</label>
                        <input type="number" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan kuota peserta">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="active">Aktif</option>
                            <option value="scheduled">Dijadwalkan</option>
                            <option value="completed">Selesai</option>
                        </select>
                    </div>
                    
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kelas</label>
                        <textarea rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition duration-300">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition duration-300">
                        Simpan Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kelas -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">Edit Kelas</h3>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6">
            <form>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                        <input type="text" value="Kelas Tahsin Al-Qur'an" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="online" selected>Online</option>
                            <option value="offline">Tatap Muka</option>
                            <option value="hybrid">Hybrid</option>
                        </select>
                    </div>
                    
                    <div id="editLinkOnlineField">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link Meeting</label>
                        <input type="text" value="zoom.us/j/123456789" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div id="editLokasiOfflineField" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" value="2023-04-15" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" value="2023-06-15" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                        <input type="time" value="19:00" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                        <input type="time" value="21:00" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pemateri/Coach</label>
                        <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="1" selected>Ust. Ahmad Fauzi</option>
                            <option value="2">Ust. Muhammad Ali</option>
                            <option value="3">Ust. Abdullah Mahmud</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kuota Peserta</label>
                        <input type="number" value="25" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="active" selected>Aktif</option>
                            <option value="scheduled">Dijadwalkan</option>
                            <option value="completed">Selesai</option>
                        </select>
                    </div>
                    
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kelas</label>
                        <textarea rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">Kelas untuk memperbaiki bacaan Al-Qur'an sesuai tajwid</textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition duration-300">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-900 text-white rounded-md hover:bg-yellow-600 transition duration-300">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Kelola Kelas -->
<div id="manageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">Kelola Kelas - Kelas Tahsin Al-Qur'an</h3>
            <button onclick="closeManageModal()" class="text-gray-500 hover:text-gray-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="mb-6">
                <h4 class="text-md font-semibold text-gray-800 mb-3">Informasi Kelas</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg">
                    <div>
                        <p class="text-sm text-gray-600">Kategori</p>
                        <p class="font-medium">Online</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal</p>
                        <p class="font-medium">15 Apr - 15 Jun 2023</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Jam</p>
                        <p class="font-medium">19:00 - 21:00 WIB</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Pemateri</p>
                        <p class="font-medium">Ust. Ahmad Fauzi</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Link Meeting</p>
                        <p class="font-medium">zoom.us/j/123456789</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="font-medium">Aktif</p>
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-md font-semibold text-gray-800">Daftar Peserta (25)</h4>
                    <button class="bg-red-900 hover:bg-red-900 text-white px-3 py-1 rounded-md text-sm flex items-center">
                        <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                        Tambah Peserta
                    </button>
                </div>
                
                <div class="border border-gray-200 rounded-lg overflow-x-auto">
                    <table class="min-w-max w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. HP</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">1</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">Ahmad</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">ahmad@example.com</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">08123456789</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    <button class="text-yellow-500 hover:text-red-900 mr-2">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-800">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">2</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">Budi</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">budi@example.com</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">08234567890</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    <button class="text-yellow-500 hover:text-red-900 mr-2">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-800">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="flex justify-between items-center mt-4 bg-gray-50 px-4 py-3 rounded-lg">
                    <div>
                        <span class="text-sm text-gray-700">Menampilkan 1 sampai 2 dari 25 entri</span>
                    </div>
                    <div class="flex space-x-1">
                        <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-md flex items-center justify-center transition duration-300">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-md font-semibold text-gray-800">Materi Kelas</h4>
                    <button class="bg-red-900 hover:bg-red-900 text-white px-3 py-1 rounded-md text-sm flex items-center">
                        <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                        Tambah Materi
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h5 class="font-medium">Pertemuan 1 - Pengenalan Tajwid</h5>
                            <div class="flex space-x-2">
                                <button class="text-yellow-500 hover:text-red-900">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Pengenalan dasar ilmu tajwid dan makhorijul huruf</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                            <span>tajwid-dasar.pdf</span>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h5 class="font-medium">Pertemuan 2 - Hukum Nun Mati</h5>
                            <div class="flex space-x-2">
                                <button class="text-yellow-500 hover:text-red-900">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Memahami hukum nun mati dan tanwin</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                            <span>nun-mati.pdf</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button onclick="closeManageModal()" class="px-4 py-2 bg-red-900 text-white rounded-md hover:bg-gray-300 hover:text-black transition duration-300">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Initialize dropdown menus
        document.querySelectorAll('.dropdown button').forEach(button => {
            button.addEventListener('click', function() {
                const menu = this.nextElementSibling;
                menu.classList.toggle('hidden');
            });
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });
        
        // Toggle lokasi/link fields based on kategori
        const kategoriSelect = document.querySelector('#addModal select');
        if (kategoriSelect) {
            kategoriSelect.addEventListener('change', function() {
                const lokasiOffline = document.getElementById('lokasiOfflineField');
                const linkOnline = document.getElementById('linkOnlineField');
                
                if (this.value === 'online') {
                    lokasiOffline.classList.add('hidden');
                    linkOnline.classList.remove('hidden');
                } else if (this.value === 'offline') {
                    lokasiOffline.classList.remove('hidden');
                    linkOnline.classList.add('hidden');
                } else { // hybrid
                    lokasiOffline.classList.remove('hidden');
                    linkOnline.classList.remove('hidden');
                }
            });
        }
        
        // Similar for edit modal
        const editKategoriSelect = document.querySelector('#editModal select');
        if (editKategoriSelect) {
            editKategoriSelect.addEventListener('change', function() {
                const lokasiOffline = document.getElementById('editLokasiOfflineField');
                const linkOnline = document.getElementById('editLinkOnlineField');
                
                if (this.value === 'online') {
                    lokasiOffline.classList.add('hidden');
                    linkOnline.classList.remove('hidden');
                } else if (this.value === 'offline') {
                    lokasiOffline.classList.remove('hidden');
                    linkOnline.classList.add('hidden');
                } else { // hybrid
                    lokasiOffline.classList.remove('hidden');
                    linkOnline.classList.remove('hidden');
                }
            });
        }
    });
    
    // Modal functions
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }
    
    function openEditModal() {
        document.getElementById('editModal').classList.remove('hidden');
    }
    
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    
    function openManageModal() {
        document.getElementById('manageModal').classList.remove('hidden');
    }
    
    function closeManageModal() {
        document.getElementById('manageModal').classList.add('hidden');
    }
    
    function confirmDelete() {
        if (confirm('Apakah Anda yakin ingin menghapus kelas ini?')) {
            alert('Kelas berhasil dihapus');
        }
    }
</script>
@endsection