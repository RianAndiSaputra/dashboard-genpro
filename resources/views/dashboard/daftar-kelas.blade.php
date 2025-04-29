@extends('layouts.app')

@section('content')
<div class="relative bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header - Shorter width and overlapping with shadow -->
    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-3/4">
        <div class="bg-yellow-500 text-center py-3 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800">Daftar Semua Kelas</h2> 
        </div>
    </div>
    
    <!-- Filter Section -->
    <br><br>
    <div class="bg-white rounded-lg shadow-md p-4 mb-2">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="statusFilter" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Dijadwalkan">Dijadwalkan</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select id="kategoriFilter" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="">Semua Kategori</option>
                    <option value="Online">Online</option>
                    <option value="Tatap Muka">Tatap Muka</option>
                    <option value="Hybrid">Hybrid</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" id="dateFilter" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div class="flex items-end">
                <button id="filterButton" class="bg-red-900 hover:bg-red-900 text-white px-4 py-2 rounded-md shadow transition duration-300 w-full">
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
    
    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="text-center py-8 hidden">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-red-900"></div>
        <p class="mt-2 text-gray-600">Memuat data...</p>
    </div>
    
    <!-- Kelas Container -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="kelasContainer">
        @foreach($kelas as $item)
        <div class="bg-white rounded-lg shadow-xl hover:shadow-2xl transition-shadow duration-300 overflow-hidden border border-black-50 border-l-4 border-l-yellow-500 kelas-card" data-id="{{ $item->id }}" data-status="{{ $item->status }}" data-kategori="{{ $item->kategori_kelas }}" data-tanggal="{{ $item->tanggal_mulai }}">
            <div class="p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $item->class_name }}</h3>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $item->kategori_kelas === 'Online' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 
                               ($item->kategori_kelas === 'Tatap Muka' ? 'bg-purple-100 text-purple-800 border border-purple-200' : 
                               'bg-orange-100 text-orange-800 border border-orange-200') }}">
                            {{ $item->kategori_kelas }}
                        </span>
                    </div>
                    <div class="dropdown relative">
                        <button class="text-gray-500 hover:text-gray-700">
                            <i data-lucide="more-vertical" class="w-5 h-5"></i>
                        </button>
                        <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden border border-gray-200">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="event.preventDefault(); openEditModal({{ $item->id }})">Edit</a>
                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" onclick="confirmDelete({{ $item->id }})">Hapus</a>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                        <span>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                        <span>{{ $item->jam_mulai }} - {{ $item->jam_selesai }} WIB</span>
                    </div>
                    @if($item->kategori_kelas === 'Online' || $item->kategori_kelas === 'Hybrid')
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="link" class="w-4 h-4 mr-2"></i>
                        <a href="{{ $item->lokasi_zoom }}" target="_blank" class="text-red-900 hover:underline truncate">{{ $item->lokasi_zoom }}</a>
                    </div>
                    @endif
                    @if($item->kategori_kelas === 'Tatap Muka' || $item->kategori_kelas === 'Hybrid')
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i>
                        <span>{{ $item->lokasi_zoom }}</span>
                    </div>
                    @endif
                    <div class="flex items-center text-sm text-gray-600 mb-1">
                        <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                        <span>{{ $item->mentees_count ?? 0 }} / {{ $item->kuota_peserta }} Peserta</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                        <span>{{ $item->mentor->name ?? 'Belum ada mentor' }}</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $item->status === 'Aktif' ? 'bg-green-100 text-green-800 border border-green-200' : 
                           ($item->status === 'Dijadwalkan' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : 
                           'bg-gray-100 text-gray-800 border border-gray-200') }}">
                        {{ $item->status }}
                    </span>
                    <button onclick="openManageModal({{ $item->id }})" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium flex items-center">
                        <i data-lucide="settings" class="w-4 h-4 mr-1"></i>
                        Kelola Kelas
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Empty State -->
    <div id="emptyState" class="text-center py-12 hidden">
        <i data-lucide="frown" class="w-12 h-12 mx-auto text-gray-400"></i>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada kelas yang ditemukan</h3>
        <p class="mt-1 text-sm text-gray-500">Coba ubah filter atau tambahkan kelas baru</p>
    </div>
    
    <!-- Pagination -->
    <div class="flex justify-between items-center mt-6 bg-white px-4 py-3 rounded-lg shadow-md">
        <div>
            <span class="text-sm text-gray-700">Menampilkan <span id="startItem">1</span> sampai <span id="endItem">{{ $kelas->count() }}</span> dari <span id="totalItems">{{ $kelas->total() }}</span> entri</span>
        </div>
        <div class="flex space-x-1">
            @if($kelas->currentPage() > 1)
            <button onclick="loadPage({{ $kelas->currentPage() - 1 }})" class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-md flex items-center justify-center transition duration-300">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </button>
            @endif
            
            @for($i = 1; $i <= $kelas->lastPage(); $i++)
                <button onclick="loadPage({{ $i }})" class="{{ $i == $kelas->currentPage() ? 'bg-red-900 text-white' : 'bg-gray-200 hover:bg-gray-300' }} px-3 py-1 rounded-md">{{ $i }}</button>
            @endfor
            
            @if($kelas->hasMorePages())
            <button onclick="loadPage({{ $kelas->currentPage() + 1 }})" class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-md flex items-center justify-center transition duration-300">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </button>
            @endif
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
            <form id="addKelasForm" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                        <input type="text" name="class_name" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="kategori_kelas" id="kategoriSelect" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                            <option value="Online">Online</option>
                            <option value="Tatap Muka">Tatap Muka</option>
                            <option value="Hybrid">Hybrid</option>
                        </select>
                    </div>
                    
                    <div id="lokasiField">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi/Link Zoom</label>
                        <input type="text" name="lokasi_zoom" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan lokasi atau link zoom">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    
                   <!-- Untuk Mentor -->
                   <!-- Di Blade -->
                   <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mentor</label>
                    <select name="mentor_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                        <option value="">Pilih Mentor</option>
                        @foreach($mentors as $mentor)
                            <option value="{{ $mentor->user_id }}">
                                {{ $mentor->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                    <!-- Untuk Sekretaris -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sekretaris</label>
                        <select name="secretary_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                            <option value="">Pilih Sekretaris</option>
                            @foreach($secretaries as $secretary)
                                <option value="{{ $secretary->user_id }}">
                                    {{ $secretary->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kuota Peserta</label>
                        <input type="number" name="kuota_peserta" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan kuota peserta" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Dijadwalkan">Dijadwalkan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Silabus / Materi (PDF)</label>
                        <input type="file" name="pdf_file" accept="application/pdf" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kelas</label>
                        <textarea name="deskripsi_kelas" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition duration-300">
                        Batal
                    </button>
                    <button type="submit" id="submitAddButton" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition duration-300">
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
            <form id="editKelasForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="kelas_id" id="editKelasId">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                        <input type="text" name="class_name" id="editClassName" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="kategori_kelas" id="editKategoriSelect" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                            <option value="Online">Online</option>
                            <option value="Tatap Muka">Tatap Muka</option>
                            <option value="Hybrid">Hybrid</option>
                        </select>
                    </div>
                    
                    <div id="editLokasiField">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi/Link Zoom</label>
                        <input type="text" name="lokasi_zoom" id="editLokasiZoom" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="editTanggalMulai" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="editTanggalSelesai" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="editJamMulai" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="editJamSelesai" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mentor</label>
                        <select name="mentor_id" id="editMentorId" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                            @foreach($mentors as $mentor)
                            <option value="{{ $mentor->user_id }}">{{ $mentor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sekretaris</label>
                        <select name="secretary_id" id="editSecretaryId" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                            @foreach($secretaries as $secretary)
                            <option value="{{ $secretary->user_id }}">{{ $secretary->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kuota Peserta</label>
                        <input type="number" name="kuota_peserta" id="editKuotaPeserta" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="editStatus" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Dijadwalkan">Dijadwalkan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Silabus / Materi (PDF)</label>
                        <input type="file" name="pdf_file" accept="application/pdf" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <div id="currentPdfFile" class="mt-2 text-sm text-gray-500"></div>
                    </div>
                    
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kelas</label>
                        <textarea name="deskripsi_kelas" id="editDeskripsi" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition duration-300">
                        Batal
                    </button>
                    <button type="submit" id="submitEditButton" class="px-4 py-2 bg-red-900 text-white rounded-md hover:bg-yellow-600 transition duration-300">
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
            <h3 class="text-lg font-bold text-gray-800" id="manageModalTitle">Kelola Kelas</h3>
            <button onclick="closeManageModal()" class="text-gray-500 hover:text-gray-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="mb-6">
                <h4 class="text-md font-semibold text-gray-800 mb-3">Informasi Kelas</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg" id="kelasInfo">
                    <!-- Info akan diisi oleh JavaScript -->
                </div>
            </div>
            
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-md font-semibold text-gray-800">Daftar Peserta (<span id="totalPeserta">0</span>)</h4>
                    <button onclick="openAddParticipantModal()" class="bg-red-900 hover:bg-red-900 text-white px-3 py-1 rounded-md text-sm flex items-center">
                        <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                        Tambah Peserta
                    </button>
                </div>
                
                <div class="border border-gray-200 rounded-lg overflow-x-auto">
                    <table class="min-w-max w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Nama</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">No. HP</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="pesertaList">
                            <!-- Daftar peserta akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
                
                <div class="flex justify-between items-center mt-4 bg-gray-50 px-4 py-3 rounded-lg">
                    <div>
                        <span class="text-sm text-gray-700">Menampilkan <span id="pesertaStart">1</span> sampai <span id="pesertaEnd">0</span> dari <span id="pesertaTotal">0</span> entri</span>
                    </div>
                    <div class="flex space-x-1" id="pesertaPagination">
                        <!-- Pagination peserta akan diisi oleh JavaScript -->
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

<!-- Modal Tambah Peserta -->
<div id="addParticipantModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">Tambah Peserta Baru</h3>
            <button onclick="closeAddParticipantModal()" class="text-gray-500 hover:text-gray-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6">
            <form id="addParticipantForm">
                <input type="hidden" name="kelas_id" id="participantKelasId">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Mentee</label>
                    <select name="user_id" id="menteeSelect" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-transparent" required>
                        <option value="">Pilih Mentee</option>
                        @foreach($mentees as $mentee)
                            <option value="{{ $mentee->user_id }}" 
                                data-email="{{ $mentee->email }}"
                                data-phone="{{ $mentee->phone }}">
                                {{ $mentee->full_name }} ({{ $mentee->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="participantEmail" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-transparent" readonly required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                    <input type="tel" name="phone" id="participantPhone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-transparent" readonly required>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeAddParticipantModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition duration-300">
                        Batal
                    </button>
                    <button type="submit" id="submitParticipantButton" class="px-4 py-2 bg-red-900 text-white rounded-md hover:bg-red-800 transition duration-300">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editPesertaModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">Edit Peserta</h3>
            <button onclick="closeEditPesertaModal()" class="text-gray-500 hover:text-gray-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6">
            <form id="editPesertaForm">
                <input type="hidden" name="mentee_id" id="editMenteeId">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" id="editPesertaNama" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-transparent" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="editPesertaEmail" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-transparent" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                    <input type="tel" id="editPesertaPhone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-transparent" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="editPesertaStatus" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-transparent">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeEditPesertaModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition duration-300">
                        Batal
                    </button>
                    <button type="submit" id="submitEditPesertaButton" class="px-4 py-2 bg-red-900 text-white rounded-md hover:bg-red-800 transition duration-300">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Peserta -->
<div id="deletePesertaModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">Konfirmasi Hapus Peserta</h3>
            <button onclick="closeDeletePesertaModal()" class="text-gray-500 hover:text-gray-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6">
            <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus peserta ini dari kelas?</p>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeletePesertaModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition duration-300">
                    Batal
                </button>
                <button type="button" id="confirmDeletePesertaButton" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-300">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('select[name="user_id"]')?.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('participantEmail').value = selectedOption.dataset.email || '';
            document.getElementById('participantPhone').value = selectedOption.dataset.phone || '';
        });

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
        
        // Handle kategori select change in add modal
        const kategoriSelect = document.getElementById('kategoriSelect');
        if (kategoriSelect) {
            kategoriSelect.addEventListener('change', function() {
                updateLokasiField(this.value);
            });
        }
        
        // Handle kategori select change in edit modal
        const editKategoriSelect = document.getElementById('editKategoriSelect');
        if (editKategoriSelect) {
            editKategoriSelect.addEventListener('change', function() {
                updateLokasiField(this.value, 'edit');
            });
        }
        
        // Form submission handlers
        document.getElementById('addKelasForm')?.addEventListener('submit', handleAddKelas);
        document.getElementById('editKelasForm')?.addEventListener('submit', handleEditKelas);
        document.getElementById('addParticipantForm')?.addEventListener('submit', handleAddParticipant);
        
        // Filter button handler
        document.getElementById('filterButton')?.addEventListener('click', applyFilters);
    });
    
    function updateLokasiField(kategori, prefix = '') {
        const lokasiField = document.getElementById(prefix + 'lokasiField');
        const placeholder = kategori === 'Online' ? 'Masukkan link Zoom/Meet' : 
                          (kategori === 'Tatap Muka' ? 'Masukkan lokasi kelas' : 'Masukkan lokasi dan link Zoom');
        
        lokasiField.innerHTML = `
            <label class="block text-sm font-medium text-gray-700 mb-1">${kategori === 'Online' ? 'Link Meeting' : 'Lokasi'}</label>
            <input type="text" name="lokasi_zoom" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                   placeholder="${placeholder}" required>
        `;
    }
    
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('addKelasForm').reset();
    }
    
    function openEditModal(id) {
        console.log('Attempting to open modal for ID:', id); // Debug
        
        fetch(`/kelas/${id}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data); // Debug
                
                if (data.status === 'success') {
                    const kelas = data.data;
                    
                    // Isi form
                    document.getElementById('editKelasId').value = kelas.id;
                    document.getElementById('editClassName').value = kelas.class_name;
                    document.getElementById('editKategoriSelect').value = kelas.kategori_kelas;
                    document.getElementById('editTanggalMulai').value = kelas.tanggal_mulai;
                    document.getElementById('editTanggalSelesai').value = kelas.tanggal_selesai;
                    document.getElementById('editJamMulai').value = kelas.jam_mulai;
                    document.getElementById('editJamSelesai').value = kelas.jam_selesai;
                    document.getElementById('editMentorId').value = kelas.mentor_id;
                    document.getElementById('editSecretaryId').value = kelas.secretary_id;
                    document.getElementById('editKuotaPeserta').value = kelas.kuota_peserta;
                    document.getElementById('editStatus').value = kelas.status;
                    document.getElementById('editDeskripsi').value = kelas.deskripsi_kelas;
                    document.getElementById('editLokasiZoom').value = kelas.lokasi_zoom;
                    
                    // Tampilkan file PDF saat ini jika ada
                    const pdfFileDiv = document.getElementById('currentPdfFile');
                    pdfFileDiv.innerHTML = kelas.pdf_path 
                        ? `File saat ini: <a href="/storage/${kelas.pdf_path}" target="_blank" class="text-red-900 hover:underline">Lihat PDF</a>`
                        : 'Tidak ada file PDF';
                    
                    // Tampilkan modal
                    document.getElementById('editModal').classList.remove('hidden');
                } else {
                    throw new Error(data.message || 'Gagal memuat data kelas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            });
    }

    // Fungsi untuk menutup modal
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Event listener untuk form submit
    document.getElementById('editKelasForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Mencegah submit default
        
        const formData = new FormData(this);
        const id = document.getElementById('editKelasId').value;
        
        fetch(`/kelas/${id}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-HTTP-Method-Override': 'PUT'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Data berhasil diperbarui');
                closeEditModal();
                window.location.reload(); // Refresh halaman
            } else {
                throw new Error(data.message || 'Gagal memperbarui data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        });
    });
    
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    
    function openManageModal(id) {
        fetchKelasDetail(id);
        document.getElementById('participantKelasId').value = id;
        document.getElementById('manageModal').classList.remove('hidden');
    }
    
    function closeManageModal() {
        document.getElementById('manageModal').classList.add('hidden');
    }
    
    function openAddParticipantModal() {
        document.getElementById('addParticipantModal').classList.remove('hidden');
    }
    
    function closeAddParticipantModal() {
        document.getElementById('addParticipantModal').classList.add('hidden');
        document.getElementById('addParticipantForm').reset();
    }
    
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus kelas ini?')) {
            fetch(`/kelas/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showNotification('success', 'Kelas berhasil dihapus');
                    // Refresh the page or update the UI
                    window.location.reload();
                } else {
                    showNotification('error', data.message || 'Gagal menghapus kelas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Terjadi kesalahan saat menghapus kelas');
            });
        }
    }
    
    function handleAddKelas(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        const submitButton = document.getElementById('submitAddButton');
        const originalText = submitButton.innerHTML;
        
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Menyimpan...';
        
        fetch('/kelas', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showNotification('success', 'Kelas berhasil ditambahkan');
                closeAddModal();
                window.location.reload();
            } else {
                showNotification('error', data.message || 'Gagal menambahkan kelas');
                if (data.errors) {
                    Object.values(data.errors).forEach(error => {
                        showNotification('error', error[0]);
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat menambahkan kelas');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
        });
    }
    
    function handleEditKelas(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const submitButton = document.getElementById('submitEditButton');
        const originalText = submitButton.innerHTML;
        const kelasId = document.getElementById('editKelasId').value;
        
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Menyimpan...';
        
        fetch(`/kelas/${kelasId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-HTTP-Method-Override': 'PUT'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showNotification('success', 'Kelas berhasil diperbarui');
                closeEditModal();
                window.location.reload();
            } else {
                showNotification('error', data.message || 'Gagal memperbarui kelas');
                if (data.errors) {
                    Object.values(data.errors).forEach(error => {
                        showNotification('error', error[0]);
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat memperbarui kelas');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
        });
    }
    
    function handleAddParticipant(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const submitButton = document.getElementById('submitParticipantButton');
        const userId = formData.get('user_id');
        
        // Validasi client-side lebih ketat
        if (!userId || userId === 'null') {
            showNotification('error', 'Silakan pilih peserta terlebih dahulu');
            return;
        }
        
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Menyimpan...';
        
        fetch('/kelas/tambah-peserta', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showNotification('success', data.message);
                closeAddParticipantModal();
                fetchKelasDetail(formData.get('kelas_id'));
            } else {
                showNotification('error', data.message || 'Gagal menambahkan peserta');
                if (data.errors) {
                    // Tampilkan semua error validasi
                    Object.values(data.errors).forEach(error => {
                        showNotification('error', error[0]);
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat menambahkan peserta');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Simpan';
        });
    }
    
    function fetchKelasDetail(id) {
        fetch(`/kelas/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const kelas = data.data;
                    
                    // Update modal title
                    document.getElementById('manageModalTitle').textContent = `Kelola Kelas - ${kelas.class_name}`;
                    
                    // Update kelas info
                    const kelasInfo = document.getElementById('kelasInfo');
                    kelasInfo.innerHTML = `
                        <div>
                            <p class="text-sm text-gray-600">Kategori</p>
                            <p class="font-medium">${kelas.kategori_kelas}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal</p>
                            <p class="font-medium">${new Date(kelas.tanggal_mulai).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' })} - ${new Date(kelas.tanggal_selesai).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jam</p>
                            <p class="font-medium">${kelas.jam_mulai} - ${kelas.jam_selesai} WIB</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Pemateri</p>
                            <p class="font-medium">${kelas.mentor?.full_name || 'Belum ditentukan'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">${kelas.kategori_kelas === 'Online' ? 'Link Meeting' : 'Lokasi'}</p>
                            <p class="font-medium">${kelas.lokasi_zoom}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="font-medium">${kelas.status}</p>
                        </div>
                    `;
                    
                    // Update peserta list
                    updatePesertaList(kelas.mentees || []);
                } else {
                    showNotification('error', data.message || 'Gagal memuat detail kelas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Terjadi kesalahan saat memuat detail kelas');
            });
    }
    
//     function updatePesertaList(peserta) {
//     const pesertaList = document.getElementById('pesertaList');
//     const totalPeserta = document.getElementById('totalPeserta');
    
//     totalPeserta.textContent = peserta.length;
    
//     if (peserta.length === 0) {
//         pesertaList.innerHTML = `
//             <tr>
//                 <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">Belum ada peserta</td>
//             </tr>
//         `;
//         return;
//     }
//     // hapusssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss
//     let html = '';
//     peserta.forEach((peserta, index) => {
//         // Gunakan status_kelas atau status tergantung response API
//         const status = peserta.status_kelas || peserta.status || 'undefined';
        
//         html += `
            
//         `;  
//     });
    
//     pesertaList.innerHTML = html;
    
//     // Reinitialize Lucide icons
//     if (typeof lucide !== 'undefined') {
//         lucide.createIcons();
//     }
// }
    
    function applyFilters() {
        const status = document.getElementById('statusFilter').value;
        const kategori = document.getElementById('kategoriFilter').value;
        const date = document.getElementById('dateFilter').value;
        
        // Show loading
        document.getElementById('loadingIndicator').classList.remove('hidden');
        document.getElementById('kelasContainer').classList.add('hidden');
        
        // Filter kelas cards
        const cards = document.querySelectorAll('.kelas-card');
        let visibleCount = 0;
        
        cards.forEach(card => {
            const cardStatus = card.dataset.status;
            const cardKategori = card.dataset.kategori;
            const cardDate = card.dataset.tanggal;
            
            const statusMatch = !status || cardStatus === status;
            const kategoriMatch = !kategori || cardKategori === kategori;
            const dateMatch = !date || cardDate === date;
            
            if (statusMatch && kategoriMatch && dateMatch) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });
        
        // Hide or show empty state
        const emptyState = document.getElementById('emptyState');
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
        
        // Update pagination info
        document.getElementById('startItem').textContent = 1;
        document.getElementById('endItem').textContent = visibleCount;
        
        // Hide loading
        document.getElementById('loadingIndicator').classList.add('hidden');
        document.getElementById('kelasContainer').classList.remove('hidden');
    }
    
    function loadPage(page) {
        const status = document.getElementById('statusFilter').value;
        const kategori = document.getElementById('kategoriFilter').value;
        const date = document.getElementById('dateFilter').value;
        
        let url = `/kelas?page=${page}`;
        if (status) url += `&status=${status}`;
        if (kategori) url += `&kategori=${kategori}`;
        if (date) url += `&date=${date}`;
        
        window.location.href = url;
    }
    
    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-md z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
        notification.innerHTML = message;
        document.body.appendChild(notification);
        
        // Auto hide after 3 seconds
        setTimeout(() => {
            notification.classList.add('opacity-0', 'transition-opacity', 'duration-300');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
    // hapussssssssssssssssssssssssssssssssssss
    // tambah peserta
    // Fungsi untuk memuat daftar peserta
// function loadParticipants(kelasId, page = 1) {
//     fetch(`/kelas/${kelasId}/peserta?page=${page}`)
//         .then(response => response.json())
//         .then(data => {
//             // Update tabel peserta
//             const tableBody = document.getElementById('pesertaList');
//             tableBody.innerHTML = data.data.map(mentee => `

//             `).join('');

//             // Update pagination
//             updatePagination(data);
//         });
// }

// Fungsi untuk mengupdate status
function updateStatus(menteeId, status) {
    fetch(`/mentee/${menteeId}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadParticipants(currentKelasId);
        }
    });
}

let currentKelasId = null;

function openManageModal(id) {
    currentKelasId = id; // Simpan ID kelas yang sedang dikelola
    fetchKelasDetail(id);
    document.getElementById('participantKelasId').value = id;
    document.getElementById('manageModal').classList.remove('hidden');
}

// Perbaikan fungsi handleAddParticipant
function handleAddParticipant(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const submitButton = document.getElementById('submitParticipantButton');
    
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Menyimpan...';
    
    fetch('/kelas/tambah-peserta', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            showNotification('success', data.message);
            closeAddParticipantModal();
            loadParticipants(currentKelasId); // Memuat ulang daftar peserta
        } else {
            showNotification('error', data.message || 'Gagal menambahkan peserta');
            if (data.errors) {
                Object.values(data.errors).forEach(error => {
                    showNotification('error', error[0]);
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Terjadi kesalahan saat menambahkan peserta');
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = 'Simpan';
    });
}

// Fungsi untuk memuat peserta
function loadParticipants(kelasId, page = 1) {
    fetch(`/kelas/${kelasId}/peserta?page=${page}`)
        .then(response => response.json())
        .then(data => {
            const pesertaList = document.getElementById('pesertaList');
            const totalPeserta = document.getElementById('totalPeserta');
            
            totalPeserta.textContent = data.total;
            
            if (data.data.length === 0) {
                pesertaList.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">Belum ada peserta</td>
                    </tr>
                `;
                return;
            }
            
            pesertaList.innerHTML = data.data.map((mentee, index) => `
                <tr>
                    <td class="px-4 py-2">${(data.current_page - 1) * 10 + index + 1}</td>
                    <td class="px-4 py-2">${mentee.user.full_name}</td>
                    <td class="px-4 py-2">${mentee.user.email}</td>
                    <td class="px-4 py-2">${mentee.user.phone}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs rounded-full 
                            ${mentee.status_kelas === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                            ${mentee.status_kelas}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        <button onclick="updateStatus(${mentee.id}, '${mentee.status_kelas === 'aktif' ? 'nonaktif' : 'aktif'}')" 
                            class="text-${mentee.status_kelas === 'aktif' ? 'red' : 'green'}-600 hover:text-${mentee.status_kelas === 'aktif' ? 'red' : 'green'}-800">
                            ${mentee.status_kelas === 'aktif' ? 'Nonaktifkan' : 'Aktifkan'}
                        </button>
                    </td>
                </tr>
            `).join('');
        });
}

// edit dan hapus peserta
// Variabel untuk menyimpan data peserta yang akan dihapus
let pesertaToDelete = null;

// Fungsi untuk membuka modal edit peserta
function editPeserta(menteeId) {
    fetch(`/mentee/${menteeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const mentee = data.data;
                
                // Isi form edit
                document.getElementById('editMenteeId').value = mentee.id;
                document.getElementById('editPesertaNama').value = mentee.user.full_name;
                document.getElementById('editPesertaEmail').value = mentee.user.email;
                document.getElementById('editPesertaPhone').value = mentee.user.phone;
                document.getElementById('editPesertaStatus').value = mentee.status_kelas;
                
                // Tampilkan modal
                document.getElementById('editPesertaModal').classList.remove('hidden');
            } else {
                throw new Error(data.message || 'Gagal memuat data peserta');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Error: ' + error.message);
        });
}

// Fungsi untuk menangani submit form edit peserta
document.getElementById('editPesertaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const menteeId = formData.get('mentee_id');
    const submitButton = document.getElementById('submitEditPesertaButton');
    const originalText = submitButton.innerHTML;
    
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Menyimpan...';
    
    fetch(`/mentee/${menteeId}/update`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            status: formData.get('status')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            showNotification('success', 'Status peserta berhasil diperbarui');
            closeEditPesertaModal();
            
            // Refresh daftar peserta
            const kelasId = document.getElementById('participantKelasId').value;
            if (kelasId) {
                fetchKelasDetail(kelasId);
            }
        } else {
            throw new Error(data.message || 'Gagal memperbarui status peserta');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Error: ' + error.message);
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    });
});

// Fungsi untuk menghapus peserta
function hapusPeserta(menteeId) {
    // Tampilkan modal konfirmasi
    document.getElementById('deletePesertaModal').classList.remove('hidden');
    
    // Set mentee ID yang akan dihapus
    document.getElementById('deletePesertaModal').dataset.menteeId = menteeId;
}

// Event listener untuk tombol konfirmasi hapus
document.getElementById('confirmDeletePesertaButton').addEventListener('click', function() {
    const menteeId = document.getElementById('deletePesertaModal').dataset.menteeId;
    const button = this;
    const originalText = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Menghapus...';
    
    fetch(`/mentee/${menteeId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            showNotification('success', 'Peserta berhasil dihapus');
            closeDeletePesertaModal();
            
            // Refresh daftar peserta
            const kelasId = document.getElementById('participantKelasId').value;
            if (kelasId) {
                fetchKelasDetail(kelasId);
            }
        } else {
            throw new Error(data.message || 'Gagal menghapus peserta');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Error: ' + error.message);
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = originalText;
    });
});

// Fungsi untuk menutup modal edit peserta
function closeEditPesertaModal() {
    document.getElementById('editPesertaModal').classList.add('hidden');
}

// Fungsi untuk membuka modal hapus peserta
function hapusPeserta(menteeId) {
    // Simpan ID peserta yang akan dihapus
    pesertaToDelete = menteeId;
    
    // Tampilkan modal konfirmasi
    document.getElementById('deletePesertaModal').classList.remove('hidden');
}

// Fungsi untuk menutup modal hapus peserta
function closeDeletePesertaModal() {
    document.getElementById('deletePesertaModal').classList.add('hidden');
    pesertaToDelete = null;
}

// Event listener untuk form edit peserta
document.getElementById('editPesertaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const menteeId = formData.get('mentee_id');
    const submitButton = document.getElementById('submitEditPesertaButton');
    const originalText = submitButton.innerHTML;
    
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Menyimpan...';
    
    fetch(`/mentee/${menteeId}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            status: formData.get('status')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', 'Status peserta berhasil diperbarui');
            closeEditPesertaModal();
            
            // Refresh daftar peserta
            if (currentKelasId) {
                loadParticipants(currentKelasId);
            }
        } else {
            showNotification('error', data.message || 'Gagal memperbarui status peserta');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Terjadi kesalahan saat memperbarui status peserta');
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    });
});

// Event listener untuk tombol hapus peserta
document.getElementById('confirmDeletePesertaButton').addEventListener('click', function() {
    if (!pesertaToDelete) return;
    
    const button = this;
    const originalText = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Menghapus...';
    
    fetch(`/delete/kelas/${pesertaToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', 'Peserta berhasil dihapus');
            closeDeletePesertaModal();
            
            // Refresh daftar peserta
            if (currentKelasId) {
                loadParticipants(currentKelasId);
            }
        } else {
            showNotification('error', data.message || 'Gagal menghapus peserta');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Terjadi kesalahan saat menghapus peserta');
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = originalText;
    });
});

// Update fungsi updatePesertaList untuk menambahkan data-mentee-id ke setiap baris
function updatePesertaList(peserta) {
    const pesertaList = document.getElementById('pesertaList');
    const totalPeserta = document.getElementById('totalPeserta');
    
    totalPeserta.textContent = peserta.length;
    
    if (peserta.length === 0) {
        pesertaList.innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">Belum ada peserta</td>
            </tr>
        `;
        return;
    }
    
    let html = '';
    peserta.forEach((peserta, index) => {
        const status = peserta.status_kelas || peserta.status || 'undefined';
        
        html += `
            <tr>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${index + 1}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${peserta.user.full_name}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${peserta.user.email || '-'}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${peserta.user.phone || '-'}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        ${status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                        ${status}
                    </span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                    <button class="text-yellow-500 hover:text-red-900 mr-2" onclick="editPeserta(${peserta.id})">
                        <i data-lucide="edit" class="w-4 h-4"></i>
                    </button>
                    <button class="text-red-600 hover:text-red-800" onclick="hapusPeserta(${peserta.id})">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </td>
            </tr>
        `;  
    });
    
    pesertaList.innerHTML = html;
    
    // Reinitialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

</script>
@endsection