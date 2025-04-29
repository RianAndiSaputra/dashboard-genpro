@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="relative bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header - Shorter width and overlapping with shadow -->
    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-3/4">
        <div class="bg-yellow-500 text-center py-3 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-users mr-2"></i> Daftar Mente Genpro Mastermind
            </h1>
        </div>
    </div>
    
    <!-- Notifikasi -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <button id="openModalBtn" class="bg-[#580720] hover:bg-[#800020] text-white px-4 py-2 rounded-lg font-medium transition mt-10">
        <i class="fas fa-user-plus mr-2"></i> Tambah Mente
    </button>
    
    <!-- Mentee Table -->
    <div class="bg-white rounded-lg shadow overflow-x-auto mt-5">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Bisnis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Bidang Usaha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Tahun Berdiri</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($mentees as $mentee)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $mentee->user->full_name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $mentee->nama_bisnis }}</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $mentee->bidang_usaha }}</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $mentee->tahun_berdiri }}</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                        <div class="flex items-center space-x-2">
                            <button onclick="showMentee({{ $mentee->id }})" 
                                class="p-2 text-blue-600 rounded-full hover:bg-blue-100"
                                title="Lihat Detail">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                            <button onclick="openEditModal(
                                '{{ $mentee->id }}',
                                '{{ $mentee->user->full_name }}',
                                '{{ $mentee->address }}',
                                '{{ $mentee->nama_bisnis }}',
                                '{{ $mentee->bidang_usaha }}',
                                '{{ $mentee->tahun_berdiri }}',
                                '{{ $mentee->badan_hukum }}',
                                '{{ $mentee->jumlah_karyawan }}',
                                '{{ $mentee->jabatan }}',
                                '{{ $mentee->user->tanggal_lahir }}'
                             )" class="text-yellow-600 hover:text-yellow-900 p-2 rounded-full hover:bg-yellow-50 flex items-center"
                                    title="Edit">
                                     <i data-lucide="pencil" class="w-5 h-5"></i>
                                     <span class="sr-only">Edit</span>
                                      </button>
                            
                                    <!-- Tombol Hapus -->
                                      <button onclick="deleteMentee({{ $mentee->id }})" 
                                    class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-50 flex items-center"
                                    title="Hapus">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                <span class="sr-only">Hapus</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Mentee Modal -->
    <div id="addMenteeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl max-h-screen overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">
                    <i class="fas fa-user-plus mr-2"></i> Formulir Pendaftaran Mente
                </h2>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Modal Content -->
            <form id="addMenteeForm" action="{{ route('mentee.register') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <!-- Form Fields -->
                <div class="space-y-6">
                    <!-- Nama (changed to full_name to match controller) -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="full_name">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="full_name" name="full_name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Username (added new field) -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="username">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="email">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Phone (added new field) -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="phone">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="phone" name="phone" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="tanggal_lahir">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Alamat Domisili (changed to address to match controller) -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="address">
                            Alamat Domisili <span class="text-red-500">*</span>
                        </label>
                        <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required></textarea>
                    </div>

                    <!-- Profile Picture (added new field) -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="profile_picture">
                            Foto Profil <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-600 mb-3">
                            Unggah foto profil Anda (maks. 2MB)
                        </p>
                        <input type="file" id="profile_picture" name="profile_picture" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" accept="image/*" required>
                    </div>

                    <!-- Nama Bisnis -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="nama_bisnis">
                            Nama Bisnis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_bisnis" name="nama_bisnis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Bidang Usaha -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="bidang_usaha">
                            Bidang Usaha <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="bidang_usaha" name="bidang_usaha" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Badan Hukum (fixed name attribute) -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="badan_hukum">
                            Badan Hukum <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="badan_hukum" name="badan_hukum" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Tahun Berdiri -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="tahun_berdiri">
                            Tahun Berdiri <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="tahun_berdiri" name="tahun_berdiri" min="1900" max="2099" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Jumlah Karyawan -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="jumlah_karyawan">
                            Jumlah Karyawan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="jumlah_karyawan" name="jumlah_karyawan" min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Omset (changed to jumlah_omset to match controller) -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="jumlah_omset">
                            Jumlah Omset (Rata-rata per tahun) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="jumlah_omset" name="jumlah_omset" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Jabatan di Genpro (changed to jabatan to match controller) -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="jabatan">
                            Jabatan di Genpro <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="jabatan" name="jabatan" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Komitmen (changed values to iya/tidak to match controller) -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">
                            Apakah Anda berkomitmen hadir setiap bulan dalam kelas Genpro Mastermind Nasional? <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-600 mb-3">
                            Keterangan: peserta yang tidak hadir 3x berturut-turut dinyatakan check out dari kelas
                        </p>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="komitmen" value="iya" class="h-5 w-5 text-[#580720] focus:ring-[#580720] border-gray-300" required>
                                <span class="ml-2">Iya</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="komitmen" value="tidak" class="h-5 w-5 text-[#580720] focus:ring-[#580720] border-gray-300">
                                <span class="ml-2">Tidak</span>
                            </label>
                        </div>
                    </div>

                    <!-- File Upload (changed to gambar_laporan to match controller) -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="gambar_laporan">
                            Upload laporan laba rugi neraca 2023 dan neraca 2024 <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-600 mb-3">
                            Upload 1 file yang diunggah. Maksimal 100 MB.
                        </p>
                        <div class="file-upload rounded-lg p-6 text-center cursor-pointer border-2 border-dashed border-gray-300" id="fileUploadArea">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-500">Seret file ke sini atau klik untuk mengunggah</p>
                            <input type="file" id="gambar_laporan" name="gambar_laporan" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                        </div>
                        <div id="fileNameDisplay" class="mt-2 text-sm text-gray-600 hidden">
                            <i class="fas fa-file mr-2"></i><span id="fileName"></span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-4">
                    <button type="button" id="cancelFormBtn" class="px-6 py-3 border rounded-lg font-medium hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="bg-[#580720] hover:bg-[#800020] text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Mentee Modal -->
    <div id="editMenteeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl max-h-screen overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">
                    <i class="fas fa-edit mr-2"></i> Edit Data Mente
                </h2>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Modal Content -->
            <form id="editMenteeForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-id" name="id">
                
                <div class="text-sm text-gray-600 mb-4">
                    <i class="fas fa-info-circle mr-2"></i> Edit data mente yang dipilih
                </div>

                <!-- Form Fields -->
                <div class="space-y-6">
                    <!-- Nama -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-nama">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-nama" name="nama" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Alamat Domisili -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-address">
                            Alamat Domisili <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-address" name="address" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Nama Bisnis -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-nama_bisnis">
                            Nama Bisnis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-nama_bisnis" name="nama_bisnis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Bidang Usaha -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-bidang_usaha">
                            Bidang Usaha <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-bidang_usaha" name="bidang_usaha" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Badan Hukum -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-badan_hukum">
                            Badan Hukum <span class="text-red-500">*</span>
                        </label>
                        <select id="edit-badan_hukum" name="badan_hukum" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                            <option value="">Pilih Badan Hukum</option>
                            <option value="PT">PT (Perseroan Terbatas)</option>
                            <option value="CV">CV (Commanditaire Vennootschap)</option>
                            <option value="UD">UD (Usaha Dagang)</option>
                            <option value="Firma">Firma</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <!-- Tahun Berdiri -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-tahun_berdiri">
                            Tahun Berdiri <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="edit-tahun_berdiri" name="tahun_berdiri" min="1900" max="2099" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Jumlah Karyawan -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-jumlah_karyawan">
                            Jumlah Karyawan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="edit-jumlah_karyawan" name="jumlah_karyawan" min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Jabatan di Genpro -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-jabatan">
                            Jabatan di Genpro <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-jabatan" name="jabatan" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-tanggal_lahir">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="edit-tanggal_lahir" name="tanggal_lahir" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-4">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 border rounded-lg font-medium hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="bg-[#580720] hover:bg-[#800020] text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Mentee Modal -->
    <div id="viewMenteeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl max-h-screen overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">
                    <i class="fas fa-eye mr-2"></i> Detail Mente
                </h2>
                <button onclick="closeViewModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Modal Content -->
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="font-semibold text-gray-700">Nama:</h3>
                        <p id="view-full_name" class="text-gray-900"></p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700">Bisnis:</h3>
                        <p id="view-nama_bisnis" class="text-gray-900"></p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700">Bidang Usaha:</h3>
                        <p id="view-bidang_usaha" class="text-gray-900"></p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700">Badan Hukum:</h3>
                        <p id="view-badan_hukum" class="text-gray-900"></p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700">Tahun Berdiri:</h3>
                        <p id="view-tahun_berdiri" class="text-gray-900"></p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700">Jumlah Karyawan:</h3>
                        <p id="view-jumlah_karyawan" class="text-gray-900"></p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700">Jabatan di Genpro:</h3>
                        <p id="view-jabatan" class="text-gray-900"></p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700">Tanggal Lahir:</h3>
                        <p id="view-tanggal_lahir" class="text-gray-900"></p>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700">Alamat Domisili:</h3>
                    <p id="view-address" class="text-gray-900"></p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end pt-4">
                <button onclick="closeViewModal()" class="px-6 py-2 bg-[#580720] hover:bg-[#800020] text-white rounded-lg font-medium transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>

    // Handle add form submission
// Handle add form submission
document.getElementById('addMenteeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    Swal.fire({
        title: 'Sedang memproses...',
        html: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: data.message || 'Mentee berhasil ditambahkan',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.reload();
        });
    })
    .catch(error => {
        let errorMessage = 'Terjadi kesalahan saat menambah data';
        if (error.errors) {
            errorMessage = Object.values(error.errors).join('<br>');
        } else if (error.message) {
            errorMessage = error.message;
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            html: errorMessage
        });
    });
});
    // lucide
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
    
    // Modal Handling
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelFormBtn = document.getElementById('cancelFormBtn');
    const modal = document.getElementById('addMenteeModal');

    openModalBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    cancelFormBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });

    // Script untuk menangani upload file dan menampilkan nama file
    document.getElementById('fileUploadArea').addEventListener('click', function() {
        document.getElementById('gambar_laporan').click();
    });

    document.getElementById('gambar_laporan').addEventListener('change', function(e) {
        if (this.files.length > 0) {
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            document.getElementById('fileName').textContent = this.files[0].name;
            fileNameDisplay.classList.remove('hidden');
        }
    });

    // Handle drag and drop
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('gambar_laporan');

    fileUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileUploadArea.classList.add('border-[#580720]', 'bg-gray-100');
    });

    fileUploadArea.addEventListener('dragleave', () => {
        fileUploadArea.classList.remove('border-[#580720]', 'bg-gray-100');
    });

    fileUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileUploadArea.classList.remove('border-[#580720]', 'bg-gray-100');
        
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            document.getElementById('fileName').textContent = e.dataTransfer.files[0].name;
            fileNameDisplay.classList.remove('hidden');
        }
    });

    // Edit Modal Functions
    function openEditModal(id, nama, address, nama_bisnis, bidang, tahun, badanHukum, karyawan, jabatan, tanggal_lahir) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-address').value = address;
        document.getElementById('edit-nama_bisnis').value = nama_bisnis;
        document.getElementById('edit-bidang_usaha').value = bidang;
        document.getElementById('edit-tahun_berdiri').value = tahun;
        document.getElementById('edit-badan_hukum').value = badanHukum;
        document.getElementById('edit-jumlah_karyawan').value = karyawan;
        document.getElementById('edit-jabatan').value = jabatan;
        document.getElementById('edit-tanggal_lahir').value = tanggal_lahir;
        
        // Set form action
        document.getElementById('editMenteeForm').action = `/mentee/${id}`;
        
        document.getElementById('editMenteeModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editMenteeModal').classList.add('hidden');
    }

    // Handle edit form submission
    document.getElementById('editMenteeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = document.getElementById('edit-id').value;
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data mente berhasil diperbarui',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.reload();
                });
            } else if (data.errors) {
                let errorMessages = '';
                for (const [key, value] of Object.entries(data.errors)) {
                    errorMessages += `${value.join('<br>')}<br>`;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: errorMessages
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat memperbarui data'
            });
        });
    });

    // View Modal Functions
    // View Modal Functions
function showMentee(id) {
    fetch(`/mentee/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('view-full_name').textContent = data.user.full_name;
            document.getElementById('view-nama_bisnis').textContent = data.nama_bisnis;
            document.getElementById('view-bidang_usaha').textContent = data.bidang_usaha;
            document.getElementById('view-badan_hukum').textContent = data.badan_hukum;
            document.getElementById('view-tahun_berdiri').textContent = data.tahun_berdiri;
            document.getElementById('view-jumlah_karyawan').textContent = data.jumlah_karyawan;
            document.getElementById('view-jabatan').textContent = data.jabatan;
            document.getElementById('view-tanggal_lahir').textContent = data.user.tanggal_lahir;
            document.getElementById('view-address').textContent = data.address;
            
            document.getElementById('viewMenteeModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat data mente');
        });
}

function closeViewModal() {
    document.getElementById('viewMenteeModal').classList.add('hidden');
}

    // Delete Mentee Function
    function deleteMentee(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#580720',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/mentee/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: 'Data mente berhasil dihapus',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.error || 'Gagal menghapus mente'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menghapus mente'
                    });
                });
            }
        });
    }

    // Close edit modal when clicking outside
    document.getElementById('editMenteeModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('editMenteeModal')) {
            closeEditModal();
        }
    });

    // Close view modal when clicking outside
    document.getElementById('viewMenteeModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('viewMenteeModal')) {
            closeViewModal();
        }
    });
</script>
@endsection