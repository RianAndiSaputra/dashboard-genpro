@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="relative bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header -->
    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-3/4">
        <div class="bg-yellow-500 text-center py-3 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-user mr-2"></i> Profil Mentee Genpro
            </h2>
            <p class="text-gray-700 text-sm">Detail informasi bisnis dan profil mentee</p>
        </div>
    </div>
    
    <!-- Notifikasi -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 mt-12" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    
    @if($errors->any()))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 mt-12" role="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <div class="mt-14">
        <!-- Foto Profil dan Info Utama -->
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 mb-8">
            <div class="flex flex-col items-center">
                @if($mentee->profile_picture)
                <img src="{{ asset('storage/' . $mentee->profile_picture) }}" alt="Foto Profil" class="w-32 h-32 rounded-full object-cover border-4 border-yellow-400 shadow-md">
            @else
                <p>Tidak ada foto profil.</p>
            @endif
                <div class="mt-3 text-center">
                    <h3 class="text-xl font-bold text-gray-800">{{ $mentee->user->full_name }}</h3>
                    <span class="inline-block px-3 py-1 text-sm font-semibold text-white bg-green-500 rounded-full mt-2">
                        <i class="fas fa-check-circle mr-1"></i> Aktif
                    </span>
                </div>
            </div>
            
            <div class="flex-1 bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Bisnis</p>
                        <p class="text-lg font-medium text-gray-800">{{ $mentee->nama_bisnis }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Bidang Usaha</p>
                        <p class="text-lg font-medium text-gray-800">{{ $mentee->bidang_usaha }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Badan Hukum</p>
                        <p class="text-lg font-medium text-gray-800">{{ $mentee->badan_hukum }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tahun Berdiri</p>
                        <p class="text-lg font-medium text-gray-800">{{ $mentee->tahun_berdiri }}</p>
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
                        <p class="text-base text-gray-800">{{ $mentee->address }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-base text-gray-800">{{ $mentee->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nomor Telepon</p>
                        <p class="text-base text-gray-800">{{ $mentee->user->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jumlah Karyawan</p>
                        <p class="text-base text-gray-800">{{ $mentee->jumlah_karyawan }} orang</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jabatan di Genpro</p>
                        <p class="text-base text-gray-800">{{ $mentee->jabatan }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Komitmen Kehadiran</p>
                        <p class="text-base text-gray-800">
                            @if($mentee->komitmen == 'iya'))
                                <span class="inline-flex items-center text-green-600">
                                    <i class="fas fa-check-circle mr-2"></i> Berkomitmen hadir setiap bulan
                                </span>
                            @else
                                <span class="inline-flex items-center text-red-600">
                                    <i class="fas fa-times-circle mr-2"></i> Tidak berkomitmen hadir setiap bulan
                                </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Lahir</p>
                        <p class="text-base text-gray-800">{{ \Carbon\Carbon::parse($mentee->user->tanggal_lahir)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Bergabung Sejak</p>
                        <p class="text-base text-gray-800">{{ \Carbon\Carbon::parse($mentee->created_at)->format('d F Y') }}</p>
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
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-800">{{ now()->format('Y') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800 text-right">Rp {{ number_format($mentee->jumlah_omset, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                @if($mentee->gambar_laporan))
                <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-file-alt mr-2"></i> Dokumen Finansial
                    </h4>
                    <div class="flex items-center">
                        <i class="fas fa-file-pdf text-red-500 text-xl mr-2"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Laporan Keuangan</p>
                            <p class="text-xs text-gray-500">Diunggah pada {{ \Carbon\Carbon::parse($mentee->updated_at)->format('d F Y') }}</p>
                        </div>
                        <a href="{{ asset('storage/' . $mentee->gambar_laporan) }}" class="ml-auto text-blue-600 hover:text-blue-800" download>
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Tombol Aksi -->
        <div class="mt-8 flex flex-col md:flex-row justify-end">
            <div class="flex space-x-3 mt-3 md:mt-0">
                <a href="{{ url()->previous() }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <button onclick="openEditModal(
                    '{{ $mentee->id }}',
                    '{{ $mentee->user->full_name }}',
                    '{{ $mentee->user->email }}',
                    '{{ $mentee->user->phone }}',
                    '{{ $mentee->user->tanggal_lahir }}',
                    '{{ $mentee->address }}',
                    '{{ $mentee->nama_bisnis }}',
                    '{{ $mentee->bidang_usaha }}',
                    '{{ $mentee->badan_hukum }}',
                    '{{ $mentee->tahun_berdiri }}',
                    '{{ $mentee->jumlah_karyawan }}',
                    '{{ $mentee->jabatan }}',
                    '{{ $mentee->komitmen }}'
                )" class="bg-[#580720] hover:bg-[#800020] text-white px-4 py-2 rounded-md transition duration-300">
                    <i class="fas fa-edit mr-2"></i> Edit Profil
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Mentee Modal -->
<div id="editMenteeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl max-h-screen overflow-y-auto">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">
                <i class="fas fa-edit mr-2"></i> Edit Profil Mentee
            </h2>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Modal Content -->
        <form id="editMenteeForm" action="{{ route('mente.profile-mente.update', ['id' => $mentee->id]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="text-sm text-gray-600 mb-4">
                <i class="fas fa-info-circle mr-2"></i> Perbarui informasi profil Anda
            </div>

            <!-- Form Fields -->
            <div class="space-y-6">
                <!-- Nama -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2" for="edit-full_name">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="edit-full_name" name="full_name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2" for="edit-email">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="edit-email" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2" for="edit-phone">
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="edit-phone" name="phone" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2" for="edit-tanggal_lahir">
                        Tanggal Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="edit-tanggal_lahir" name="tanggal_lahir" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required>
                </div>

                <!-- Alamat Domisili -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2" for="edit-address">
                        Alamat Domisili <span class="text-red-500">*</span>
                    </label>
                    <textarea id="edit-address" name="address" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" required></textarea>
                </div>

                <!-- Foto Profil -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2" for="edit-profile_picture">
                        Foto Profil
                    </label>
                    <p class="text-sm text-gray-600 mb-3">
                        Unggah foto profil baru (maks. 2MB) atau biarkan kosong untuk mempertahankan foto saat ini
                    </p>
                    <input type="file" id="edit-profile_picture" name="profile_picture" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]" accept="image/*">
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
                            <span class="ml-2">Iya</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="komitmen" value="tidak" class="h-5 w-5 text-[#580720] focus:ring-[#580720] border-gray-300">
                            <span class="ml-2">Tidak</span>
                        </label>
                    </div>
                </div>

                <!-- Laporan Keuangan -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2" for="edit-gambar_laporan">
                        Upload laporan keuangan baru
                    </label>
                    <p class="text-sm text-gray-600 mb-3">
                        Unggah file baru atau biarkan kosong untuk mempertahankan dokumen saat ini. Maksimal 100 MB.
                    </p>
                    <div class="file-upload rounded-lg p-6 text-center cursor-pointer border-2 border-dashed border-gray-300" id="fileUploadArea">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-500">Seret file ke sini atau klik untuk mengunggah</p>
                        <input type="file" id="edit-gambar_laporan" name="gambar_laporan" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx">
                    </div>
                    <div id="fileNameDisplay" class="mt-2 text-sm text-gray-600 hidden">
                        <i class="fas fa-file mr-2"></i><span id="fileName"></span>
                    </div>
                    @if($mentee->gambar_laporan))
                    <div class="mt-2 text-sm text-gray-600">
                        <i class="fas fa-file mr-2"></i>Dokumen saat ini: <span class="font-medium">Laporan Keuangan</span>
                    </div>
                    @endif
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

<script>
    // Edit Modal Functions
    function openEditModal(id, fullName, email, phone, tanggalLahir, address, namaBisnis, bidangUsaha, badanHukum, tahunBerdiri, jumlahKaryawan, jabatan, komitmen) {
        // Show the modal
        document.getElementById('editMenteeModal').classList.remove('hidden');
        
        // Pre-fill form fields with provided data
        document.getElementById('edit-full_name').value = fullName;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-phone').value = phone;
        document.getElementById('edit-tanggal_lahir').value = tanggalLahir;
        document.getElementById('edit-address').value = address;
        document.getElementById('edit-nama_bisnis').value = namaBisnis;
        document.getElementById('edit-bidang_usaha').value = bidangUsaha;
        document.getElementById('edit-badan_hukum').value = badanHukum;
        document.getElementById('edit-tahun_berdiri').value = tahunBerdiri;
        document.getElementById('edit-jumlah_karyawan').value = jumlahKaryawan;
        document.getElementById('edit-jabatan').value = jabatan;
        
        // Set radio buttons based on komitmen value
        if (komitmen === "iya") {
            document.querySelector('input[name="komitmen"][value="iya"]').checked = true;
        } else {
            document.querySelector('input[name="komitmen"][value="tidak"]').checked = true;
        }
    }

    function closeEditModal() {
        document.getElementById('editMenteeModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('editMenteeModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('editMenteeModal')) {
            closeEditModal();
        }
    });

    // File upload handling
    document.getElementById('fileUploadArea').addEventListener('click', function() {
        document.getElementById('edit-gambar_laporan').click();
    });

    document.getElementById('edit-gambar_laporan').addEventListener('change', function(e) {
        if (this.files.length > 0) {
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            document.getElementById('fileName').textContent = this.files[0].name;
            fileNameDisplay.classList.remove('hidden');
        }
    });

    // Handle drag and drop
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('edit-gambar_laporan');

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

    // Form submission with SweetAlert
    document.getElementById('editMenteeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
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
                    text: data.message || 'Profil berhasil diperbarui',
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
                text: 'Terjadi kesalahan saat memperbarui profil'
            });
        });
    });
</script>
@endsection