<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Genpro Mastermind Nasional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .file-upload {
            border: 2px dashed #cbd5e0;
            transition: all 0.3s ease;
        }
        .file-upload:hover {
            border-color: #580720;
            background-color: #f9fafb;
        }
        .radio-checked {
            border-color: #580720;
            background-color: #580720;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-[#580720] text-white p-4 shadow-md">
            <div class="container mx-auto">
                <h1 class="text-2xl font-bold">Form Pendataan Calon Peserta Genpro</h1>
                <p class="mt-1">Mastermind Nasional</p>
            </div>
        </header>

        <main class="container mx-auto p-4 max-w-4xl">
            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Form Header -->
                <div class="bg-[#580720] text-white p-4">
                    <h2 class="text-xl font-bold">
                        <i class="fas fa-user-plus mr-2"></i> Formulir Pendaftaran
                    </h2>
                    <p class="text-sm mt-1 opacity-90">
                        Assalamu'alaykum warahmatullahi wabarakatuh
                    </p>
                    <p class="text-sm mt-1 opacity-90">
                        Silahkan isi data dibawah ini sebagai asesmen awal kelas Genpro Mastermind Nasional
                    </p>
                </div>

                <!-- Google Account Info -->
                <div class="border-b p-4 bg-gray-50 flex items-center justify-between">
                    <div>
                        <span class="text-sm text-gray-600">Akun Google terdeteksi:</span>
                        <p class="font-medium">statistikpengunjung@gmail.com</p>
                    </div>
                    <button class="text-[#580720] hover:text-[#800020] text-sm font-medium">
                        <i class="fas fa-sync-alt mr-1"></i> Ganti akun
                    </button>
                </div>

                <!-- Form Content -->
                <form class="p-6 space-y-6">
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
                                    <label class="block text-gray-600 text-sm mb-1">2021</label>
                                    <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                                </div>
                                <div>
                                    <label class="block text-gray-600 text-sm mb-1">2022</label>
                                    <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                                </div>
                                <div>
                                    <label class="block text-gray-600 text-sm mb-1">2023</label>
                                    <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#580720] focus:border-[#580720]">
                                </div>
                                <div>
                                    <label class="block text-gray-600 text-sm mb-1">2024</label>
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
                            <div class="file-upload rounded-lg p-6 text-center cursor-pointer" id="fileUploadArea">
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
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                        <button type="button" class="px-6 py-3 border rounded-lg font-medium hover:bg-gray-100">
                            Kosongkan formulir
                        </button>
                        <button type="submit" class="bg-[#580720] hover:bg-[#800020] text-white px-6 py-3 rounded-lg font-medium transition">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
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
    </script>
</body>
</html>