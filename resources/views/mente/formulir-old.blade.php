@extends('layouts.app')
@section('content')
<div class="relative bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header - Shorter width and overlapping with shadow -->
    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-3/4">
        <div class="bg-yellow-500 text-center py-3 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-users mr-2"></i> Daftar Mente Genpro Mastermind
            </h1>
        </div>
    </div>
    <button id="openModalBtn"  class="bg-[#580720] hover:bg-[#800020] text-white px-4 py-2 rounded-lg font-medium transition mt-10 cursor-pointer z-10 relative" style="position: relative; z-index: 1000; cursor: pointer;">
        <i class="fas fa-user-plus mr-2"></i> Tambah Mente
    </button>
    
    <!-- Display success message if any -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    
    <!-- Display error message if any -->
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif
    
    <!-- Mentee Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden mt-5">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Username</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Bisnis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Bidang Usaha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Tahun Berdiri</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($mentees as $mentee)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $mentee->user->full_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $mentee->user->username }}</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $mentee->bisnis }}</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $mentee->bidang_usaha }}</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $mentee->tahun_berdiri }}</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                        <button class="text-blue-600 hover:text-blue-900 mr-3" onclick="viewMentee({{ $mentee->id }})"><i class="fas fa-eye"></i></button>
                        <button class="text-yellow-600 hover:text-yellow-900 mr-3" onclick="openEditModal('{{ $mentee->user->full_name }}', '{{ $mentee->user->username }}', '{{ $mentee->bisnis }}', '{{ $mentee->bidang_usaha }}', '{{ $mentee->tahun_berdiri }}', '{{ $mentee->badan_hukum }}', '{{ $mentee->jumlah_karyawan }}', '{{ $mentee->jabatan }}', '{{ $mentee->id }}')"><i class="fas fa-edit"></i></button>
                        <button class="text-red-600 hover:text-red-900" onclick="deleteMentee({{ $mentee->id }})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-center">Tidak ada data mente</td>
                </tr>
                @endforelse
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
            
            <!-- Modal Content - Using your existing form with additions -->
            <form class="space-y-6" action="{{ route('mentees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="text-sm text-gray-600 mb-4">
                    <i class="fas fa-info-circle mr-2"></i> Data yang diisi akan digunakan untuk membuat akun mente
                </div>

                <!-- Form Fields -->
                <div class="space-y-6">
                    <!-- Username -->
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

                    <!-- Nama -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="full_name">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="full_name" name="full_name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>
                    
                    <!-- Phone -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="phone">
                            No. Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="phone" name="phone" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="tanggal_lahir">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                        <p class="text-sm text-gray-500 mt-1">Tanggal lahir akan digunakan sebagai password awal untuk login</p>
                    </div>
                    
                    <!-- Alamat Domisili -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="address">
                            Alamat Domisili <span class="text-red-500">*</span>
                        </label>
                        <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required></textarea>
                    </div>

                    <!-- Nama Bisnis -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="bisnis">
                            Nama Bisnis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="bisnis" name="bisnis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Bidang Usaha -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="bidang_usaha">
                            Bidang Usaha <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="bidang_usaha" name="bidang_usaha" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Badan Hukum -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="badan_hukum">
                            Badan Hukum <span class="text-red-500">*</span>
                        </label>
                        <select id="badan_hukum" name="badan_hukum" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
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

                    <!-- Omset -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="jumlah_omset">
                            Jumlah Omset <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="jumlah_omset" name="jumlah_omset" min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>
                    
                    <!-- Jabatan di Genpro -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="jabatan">
                            Jabatan di Genpro <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="jabatan" name="jabatan" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Komitmen -->
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
                                <span class="ml-2">Ya</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="komitmen" value="tidak" class="h-5 w-5 text-[#580720] focus:ring-[#580720] border-gray-300">
                                <span class="ml-2">Tidak</span>
                            </label>
                        </div>
                    </div>

                    <!-- Profile Picture -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="profile_picture">
                            Foto Profil <span class="text-red-500">*</span>
                        </label>
                        <input type="file" id="profile_picture" name="profile_picture" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" accept="image/*" required>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="gambar_laporan">
                            Upload laporan laba rugi neraca <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-600 mb-3">
                            Upload 1 file yang diunggah. Maksimal 2 MB.
                        </p>
                        <input type="file" id="gambar_laporan" name="gambar_laporan" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" accept="image/*" required>
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
            <form id="editForm" class="space-y-6" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                        <input type="text" id="edit-nama" name="full_name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Alamat Domisili -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-alamat">
                            Alamat Domisili <span class="text-red-500">*</span>
                        </label>
                        <textarea id="edit-alamat" name="address" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required></textarea>
                    </div>

                    <!-- Nama Bisnis -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-bisnis">
                            Nama Bisnis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-bisnis" name="bisnis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Bidang Usaha -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-bidang">
                            Bidang Usaha <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-bidang" name="bidang_usaha" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Badan Hukum -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-badan-hukum">
                            Badan Hukum <span class="text-red-500">*</span>
                        </label>
                        <select id="edit-badan-hukum" name="badan_hukum" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
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
                        <label class="block text-gray-700 font-bold mb-2" for="edit-tahun">
                            Tahun Berdiri <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="edit-tahun" name="tahun_berdiri" min="1900" max="2099" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Jumlah Karyawan -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-karyawan">
                            Jumlah Karyawan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="edit-karyawan" name="jumlah_karyawan" min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Jabatan di Genpro -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-jabatan">
                            Jabatan di Genpro <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-jabatan" name="jabatan" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                    </div>

                    <!-- Profile Picture -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-profile-picture">
                            Ganti Foto Profil (Opsional)
                        </label>
                        <input type="file" id="edit-profile-picture" name="profile_picture" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" accept="image/*">
                    </div>

                    <!-- File Upload -->
<div>
  <label class="block text-gray-700 font-bold mb-2" for="edit-gambar-laporan">
      Ganti Laporan Laba Rugi Neraca (Opsional)
  </label>
  <input type="file" id="edit-gambar-laporan" name="gambar_laporan" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" accept="image/*">
</div>
</div>

<!-- Hidden ID field -->
<input type="hidden" id="edit-mentee-id" name="mentee_id">

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
          <i class="fas fa-user mr-2"></i> Detail Mente
      </h2>
      <button onclick="closeViewModal()" class="text-gray-500 hover:text-gray-700">
          <i class="fas fa-times"></i>
      </button>
  </div>
  
  <!-- Modal Content -->
  <div class="space-y-6">
      <div class="flex flex-col md:flex-row md:space-x-6">
          <!-- Profile Picture -->
          <div class="mb-4 md:mb-0 flex-none">
              <div id="profile-pic-container" class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 border-4 border-[#580720]">
                  <img id="view-profile-pic" class="w-full h-full object-cover" src="" alt="Profile Picture">
              </div>
          </div>
          
          <!-- Basic Information -->
          <div class="flex-grow">
              <h3 id="view-name" class="text-xl font-bold text-[#580720]"></h3>
              <p id="view-username" class="text-gray-600 mb-2"></p>
              <p id="view-email" class="text-gray-600 mb-2"></p>
              <p id="view-phone" class="text-gray-600 mb-2"></p>
              <p id="view-address" class="text-gray-600"></p>
          </div>
      </div>

      <hr class="my-4">
      
      <!-- Business Information -->
      <div>
          <h3 class="text-lg font-bold mb-3">Informasi Bisnis</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                  <p class="font-medium text-gray-700">Nama Bisnis:</p>
                  <p id="view-bisnis" class="text-gray-900"></p>
              </div>
              <div>
                  <p class="font-medium text-gray-700">Bidang Usaha:</p>
                  <p id="view-bidang" class="text-gray-900"></p>
              </div>
              <div>
                  <p class="font-medium text-gray-700">Badan Hukum:</p>
                  <p id="view-badan-hukum" class="text-gray-900"></p>
              </div>
              <div>
                  <p class="font-medium text-gray-700">Tahun Berdiri:</p>
                  <p id="view-tahun" class="text-gray-900"></p>
              </div>
              <div>
                  <p class="font-medium text-gray-700">Jumlah Karyawan:</p>
                  <p id="view-karyawan" class="text-gray-900"></p>
              </div>
              <div>
                  <p class="font-medium text-gray-700">Jumlah Omset:</p>
                  <p id="view-omset" class="text-gray-900"></p>
              </div>
              <div>
                  <p class="font-medium text-gray-700">Jabatan di Genpro:</p>
                  <p id="view-jabatan" class="text-gray-900"></p>
              </div>
              <div>
                  <p class="font-medium text-gray-700">Komitmen Hadir:</p>
                  <p id="view-komitmen" class="text-gray-900"></p>
              </div>
          </div>
      </div>

      <hr class="my-4">

      <!-- Laporan Dokumen -->
      <div>
          <h3 class="text-lg font-bold mb-3">Laporan Laba Rugi</h3>
          <div id="laporan-container" class="w-full max-h-96 overflow-hidden border rounded-lg">
              <img id="view-laporan" class="w-full object-contain" src="" alt="Laporan">
          </div>
      </div>

      <!-- Close Button -->
      <div class="flex justify-end mt-6">
          <button onclick="closeViewModal()" class="bg-[#580720] hover:bg-[#800020] text-white px-6 py-3 rounded-lg font-medium transition">
              <i class="fas fa-times mr-2"></i> Tutup
          </button>
      </div>
  </div>
</div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
<div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
  <h2 class="text-xl font-bold mb-4">
      <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i> Konfirmasi Hapus
  </h2>
  <p class="mb-6">Apakah Anda yakin ingin menghapus data mente ini? Tindakan ini tidak dapat dibatalkan.</p>
  <div class="flex justify-end space-x-3">
      <button onclick="closeDeleteModal()" class="px-4 py-2 border rounded-lg font-medium hover:bg-gray-100">
          Batal
      </button>
      <form id="deleteForm" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition">
              <i class="fas fa-trash mr-2"></i> Hapus
          </button>
      </form>
  </div>
</div>
</div>
</div>
@endsection

@section('scripts')
<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Display SweetAlert notifications if there are session messages
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Sukses!',
    text: '{{ session('success') }}',
    timer: 3000,
    showConfirmButton: false
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ session('error') }}',
    timer: 3000,
    showConfirmButton: false
});
@endif

// Add Mentee Modal Functions
const openModalBtn = document.getElementById('openModalBtn');
openModalBtn.style.pointerEvents = 'auto'; // Pastikan pointer events aktif
openModalBtn.addEventListener('click', function() {
    console.log("Tombol Tambah Mente diklik");
    const modal = document.getElementById('addMenteeModal');
    modal.classList.remove('hidden');
    modal.style.display = 'flex'; // Paksa tampilkan modal
    console.log("Modal harus muncul sekarang!");
});

// Tutup Modal
document.getElementById('closeModalBtn').onclick = function() {

// Tutup Modal
document.getElementById('closeModalBtn').onclick = function() {
    document.getElementById('addMenteeModal').classList.add('hidden');
};

// View Mentee Details
function viewMentee(id) {
    // Fetch mentee data from server
    fetch(`/mentees/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Populate the view modal with data
            document.getElementById('view-name').textContent = data.user.full_name;
            document.getElementById('view-username').textContent = `@${data.user.username}`;
            document.getElementById('view-email').textContent = data.user.email;
            document.getElementById('view-phone').textContent = data.user.phone;
            document.getElementById('view-address').textContent = data.user.address;
            
            document.getElementById('view-bisnis').textContent = data.bisnis;
            document.getElementById('view-bidang').textContent = data.bidang_usaha;
            document.getElementById('view-badan-hukum').textContent = data.badan_hukum;
            document.getElementById('view-tahun').textContent = data.tahun_berdiri;
            document.getElementById('view-karyawan').textContent = data.jumlah_karyawan;
            document.getElementById('view-omset').textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.jumlah_omset);
            document.getElementById('view-jabatan').textContent = data.jabatan;
            document.getElementById('view-komitmen').textContent = data.komitmen === 'iya' ? 'Ya' : 'Tidak';
            
            // Set profile picture
            if (data.user.profile_picture) {
                document.getElementById('view-profile-pic').src = `/storage/${data.user.profile_picture}`;
            } else {
                document.getElementById('view-profile-pic').src = '/images/default-profile.png';
            }
            
            // Set laporan image
            if (data.gambar_laporan) {
                document.getElementById('view-laporan').src = `/storage/${data.gambar_laporan}`;
            } else {
                document.getElementById('view-laporan').src = '/images/no-document.png';
            }
            
            // Show the modal
            document.getElementById('viewMenteeModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        })
        .catch(error => {
            console.error('Error fetching mentee data:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal mengambil data mente. Silakan coba lagi.',
                timer: 3000
            });
        });
}

function closeViewModal() {
    document.getElementById('viewMenteeModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Edit Mentee Functions
function openEditModal(name, username, bisnis, bidang_usaha, tahun_berdiri, badan_hukum, jumlah_karyawan, jabatan, id) {
    // Set form action
    document.getElementById('editForm').action = `/mentees/${id}`;
    
    // Fill form with current values
    document.getElementById('edit-nama').value = name;
    document.getElementById('edit-bisnis').value = bisnis;
    document.getElementById('edit-bidang').value = bidang_usaha;
    document.getElementById('edit-tahun').value = tahun_berdiri;
    document.getElementById('edit-badan-hukum').value = badan_hukum;
    document.getElementById('edit-karyawan').value = jumlah_karyawan;
    document.getElementById('edit-jabatan').value = jabatan;
    document.getElementById('edit-mentee-id').value = id;
    
    // Fetch additional data that might not be in the table
    fetch(`/mentees/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit-alamat').value = data.user.address || '';
            // Show the modal after data is loaded
            document.getElementById('editMenteeModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        })
        .catch(error => {
            console.error('Error fetching mentee data:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal mengambil data lengkap mente. Beberapa field mungkin tidak terisi.',
                timer: 3000
            });
            // Show the modal anyway
            document.getElementById('editMenteeModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
}

function closeEditModal() {
    document.getElementById('editMenteeModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Delete Mentee Functions
function deleteMentee(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data mente akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the delete form
            document.getElementById('deleteForm').action = `/mentees/${id}`;
            document.getElementById('deleteForm').submit();
        }
    });
}

// Form submission handling
document.addEventListener('DOMContentLoaded', function() {
    // Handle add mentee form submission
    const addForm = document.querySelector('#addMenteeModal form');
    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: data.message,
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message,
                        timer: 3000
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data',
                    timer: 3000
                });
            });
        });
    }

    // Handle edit mentee form submission
    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-HTTP-Method-Override': 'PUT'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: data.message,
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message,
                        timer: 3000
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data',
                    timer: 3000
                });
            });
        });
    }
});
</script>
@endsection