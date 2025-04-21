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
    <button id="openModalBtn" class="bg-[#580720] hover:bg-[#800020] text-white px-4 py-2 rounded-lg font-medium transition mt-10">
        <i class="fas fa-user-plus mr-2"></i> Tambah Mente
    </button>
    <!-- Mentee Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden mt-5">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Bisnis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Bidang Usaha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Tahun Berdiri</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Sample Data - Replace with dynamic data from your backend -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">John Doe</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">Doe Enterprises</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">Retail</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">2015</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                        <button class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye"></i></button>
                        <button onclick="openEditModal('John Doe', 'Doe Enterprises', 'Retail', '2015', 'PT', '10', 'CEO')" class="text-yellow-600 hover:text-yellow-900 mr-3"><i class="fas fa-edit"></i></button>
                        <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">Jane Smith</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">Smith & Co</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">Manufacturing</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">2018</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                        <button class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye"></i></button>
                        <button onclick="openEditModal('Jane Smith', 'Smith & Co', 'Manufacturing', '2018', 'CV', '25', 'Director')" class="text-yellow-600 hover:text-yellow-900 mr-3"><i class="fas fa-edit"></i></button>
                        <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <!-- Add more rows as needed -->
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
            
            <!-- Modal Content - Using your existing form -->
            <form class="space-y-6">
                <div class="text-sm text-gray-600 mb-4">
                    <i class="fas fa-info-circle mr-2"></i> Nama, alamat email, dan foto yang terkait dengan Akun Google Anda akan direkam saat Anda mengupload file dan mengirimkan formulir ini
                </div>

                <!-- Form Fields -->
                <div class="space-y-6">
                    <!-- Nama -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="nama">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                    </div>

                    <!-- Alamat Domisili -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="alamat">
                            Alamat Domisili <span class="text-red-500">*</span>
                        </label>
                        <textarea id="alamat" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]"></textarea>
                    </div>

                    <!-- Nama Bisnis -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="bisnis">
                            Nama Bisnis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="bisnis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                    </div>

                    <!-- Bidang Usaha -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="bidang">
                            Bidang Usaha <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="bidang" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                    </div>

                    <!-- Badan Hukum -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="badan-hukum">
                            Badan Hukum <span class="text-red-500">*</span>
                        </label>
                        <select id="badan-hukum" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
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
                        <label class="block text-gray-700 font-bold mb-2" for="tahun">
                            Tahun Berdiri <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="tahun" min="1900" max="2099" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                    </div>

                    <!-- Jumlah Karyawan -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="karyawan">
                            Jumlah Karyawan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="karyawan" min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                    </div>

                    <!-- Omset -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="omset">
                            Jumlah Omset (2021, 2022, 2023 dan 2024) <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-600 text-sm mb-1">input data</label>
                                <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                            </div>
                        </div>
                    </div>
                    <!-- Jabatan di Genpro -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="jabatan">
                            Jabatan di Genpro <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="jabatan" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
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
                                <input type="radio" name="komitmen" value="ya" class="h-5 w-5 text-[#580720] focus:ring-[#580720] border-gray-300">
                                <span class="ml-2">Ya</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="komitmen" value="tidak" class="h-5 w-5 text-[#580720] focus:ring-[#580720] border-gray-300">
                                <span class="ml-2">Tidak</span>
                            </label>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">
                            Upload laporan laba rugi neraca 2023 dan neraca 2024 <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-600 mb-3">
                            Upload 1 file yang diunggah. Maksimal 100 MB.
                        </p>
                        <div class="file-upload rounded-lg p-6 text-center cursor-pointer border-2 border-dashed border-gray-300" id="fileUploadArea">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-500">Seret file ke sini atau klik untuk mengunggah</p>
                            <input type="file" id="fileUpload" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx">
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
            <form class="space-y-6">
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
                        <input type="text" id="edit-nama" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                    </div>

                    <!-- Alamat Domisili -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-alamat">
                            Alamat Domisili <span class="text-red-500">*</span>
                        </label>
                        <textarea id="edit-alamat" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]"></textarea>
                    </div>

                    <!-- Nama Bisnis -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-bisnis">
                            Nama Bisnis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-bisnis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                    </div>

                    <!-- Bidang Usaha -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-bidang">
                            Bidang Usaha <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-bidang" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                    </div>

                    <!-- Badan Hukum -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-badan-hukum">
                            Badan Hukum <span class="text-red-500">*</span>
                        </label>
                        <select id="edit-badan-hukum" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
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
                        <input type="number" id="edit-tahun" min="1900" max="2099" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                    </div>

                    <!-- Jumlah Karyawan -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-karyawan">
                            Jumlah Karyawan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="edit-karyawan" min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                    </div>

                    <!-- Jabatan di Genpro -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="edit-jabatan">
                            Jabatan di Genpro <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-jabatan" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
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
</div>

<script>
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

// File Upload Interaction
const fileUpload = document.getElementById('fileUpload');
const fileUploadArea = document.getElementById('fileUploadArea');
const fileNameDisplay = document.getElementById('fileNameDisplay');
const fileName = document.getElementById('fileName');

fileUploadArea.addEventListener('click', () => {
    fileUpload.click();
});

fileUpload.addEventListener('change', (e) => {
    if (e.target.files.length > 0) {
        const uploadedFile = e.target.files[0];
        fileName.textContent = uploadedFile.name;
        fileNameDisplay.classList.remove('hidden');
        
        // Update upload area appearance
        fileUploadArea.innerHTML = `
            <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
            <p class="text-sm font-medium">${uploadedFile.name}</p>
            <p class="text-xs text-gray-500">${(uploadedFile.size / (1024*1024)).toFixed(2)} MB</p>
        `;
        fileUploadArea.classList.add('border-green-400', 'bg-green-50');
    }
});

// Drag and drop functionality
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
        fileUpload.files = e.dataTransfer.files;
        const event = new Event('change');
        fileUpload.dispatchEvent(event);
    }
});

// Edit Modal Functions
function openEditModal(nama, bisnis, bidang, tahun, badanHukum, karyawan, jabatan) {
    document.getElementById('edit-nama').value = nama;
    document.getElementById('edit-bisnis').value = bisnis;
    document.getElementById('edit-bidang').value = bidang;
    document.getElementById('edit-tahun').value = tahun;
    document.getElementById('edit-badan-hukum').value = badanHukum;
    document.getElementById('edit-karyawan').value = karyawan;
    document.getElementById('edit-jabatan').value = jabatan;
    
    document.getElementById('editMenteeModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editMenteeModal').classList.add('hidden');
}

// Close edit modal when clicking outside
document.getElementById('editMenteeModal').addEventListener('click', (e) => {
    if (e.target === document.getElementById('editMenteeModal')) {
        closeEditModal();
    }
});
</script>
@endsection