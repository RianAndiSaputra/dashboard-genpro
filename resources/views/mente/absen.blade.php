<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Real-time</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #video {
            transform: scaleX(-1); /* Mirror effect for camera */
        }
        .attendance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-[#580720] text-white p-4 shadow-md">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Sistem Absensi</h1>
                <div id="realTimeClock" class="text-xl font-mono bg-[#800020] px-4 py-2 rounded-lg">
                    Loading...
                </div>
            </div>
        </header>

        <main class="container mx-auto p-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Camera & Attendance Form -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Camera Section -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="bg-[#580720] text-white p-3 font-bold">
                            <i class="fas fa-camera mr-2"></i> Kamera Absensi
                        </div>
                        <div class="p-4">
                            <div class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden">
                                <video id="video" width="100%" autoplay></video>
                            </div>
                            <div class="mt-3 text-center text-sm text-gray-500">
                                Pastikan wajah terlihat jelas dalam frame
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Action -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="bg-[#580720] text-white p-3 font-bold">
                            <i class="fas fa-edit mr-2"></i> Aksi Absensi
                        </div>
                        <div class="p-4 space-y-4">
                            <div class="grid grid-cols-2 gap-3">
                                <button id="captureBtn" class="bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-bold transition">
                                    <i class="fas fa-camera mr-2"></i> Absen Masuk
                                </button>
                                <button id="captureOutBtn" class="bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-lg font-bold transition">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Absen Pulang
                                </button>
                            </div>

                            <div class="border-t pt-4">
                                <button id="permissionBtn" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 px-4 rounded-lg font-bold transition">
                                    <i class="fas fa-envelope mr-2"></i> Ajukan Izin
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Attendance List -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="bg-[#580720] text-white p-3 font-bold">
                            <i class="fas fa-history mr-2"></i> Riwayat Absensi
                        </div>
                        <div class="p-4">
                            <!-- Filter Section -->
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
                                <div class="flex items-center">
                                    <span class="mr-2 text-sm font-medium">Filter:</span>
                                    <select class="border rounded-lg px-3 py-2 text-sm">
                                        <option>Semua</option>
                                        <option>Hari Ini</option>
                                        <option>Minggu Ini</option>
                                        <option>Bulan Ini</option>
                                    </select>
                                </div>
                                <div class="relative">
                                    <input type="text" placeholder="Cari absensi..." class="border rounded-lg pl-10 pr-4 py-2 text-sm w-full md:w-64">
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Attendance List -->
                            <div class="space-y-3">
                                <!-- Sample Attendance Item 1 -->
                                <div class="attendance-card bg-white border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-3">
                                            <div class="bg-green-100 text-green-800 rounded-full p-2">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-bold">Absen Masuk</h3>
                                                <p class="text-sm text-gray-600">12 Mei 2023 - 08:05:23</p>
                                                <p class="text-xs mt-1">
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Tepat Waktu</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium">Lokasi: Kantor Pusat</p>
                                            <button class="text-blue-600 hover:text-blue-800 text-sm mt-1">
                                                <i class="fas fa-image mr-1"></i> Lihat Foto
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sample Attendance Item 2 -->
                                <div class="attendance-card bg-white border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-3">
                                            <div class="bg-red-100 text-red-800 rounded-full p-2">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-bold">Absen Pulang</h3>
                                                <p class="text-sm text-gray-600">12 Mei 2023 - 17:32:45</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium">Lokasi: Kantor Pusat</p>
                                            <button class="text-blue-600 hover:text-blue-800 text-sm mt-1">
                                                <i class="fas fa-image mr-1"></i> Lihat Foto
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sample Attendance Item 3 -->
                                <div class="attendance-card bg-white border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-3">
                                            <div class="bg-yellow-100 text-yellow-800 rounded-full p-2">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-bold">Izin Sakit</h3>
                                                <p class="text-sm text-gray-600">15 Mei 2023 - 07:15:00</p>
                                                <p class="text-xs mt-1">
                                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded">Dokter: Dr. Andi</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Catatan: Demam tinggi, ada surat dokter</p>
                                            <button class="text-blue-600 hover:text-blue-800 text-sm mt-1">
                                                <i class="fas fa-paperclip mr-1"></i> Lihat Dokumen
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="flex justify-between items-center mt-6 border-t pt-4">
                                <div class="text-sm text-gray-600">
                                    Menampilkan 1-3 dari 15 data
                                </div>
                                <div class="flex space-x-1">
                                    <button class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-100">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button class="px-3 py-1 border rounded-lg bg-[#580720] text-white text-sm">1</button>
                                    <button class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-100">2</button>
                                    <button class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-100">3</button>
                                    <button class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-100">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Permission Modal (Hidden by default) -->
    <div id="permissionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-md mx-4">
            <div class="bg-[#580720] text-white p-4 rounded-t-lg flex justify-between items-center">
                <h3 class="font-bold text-lg"><i class="fas fa-envelope mr-2"></i> Ajukan Izin</h3>
                <button id="closeModal" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="permissionType">
                            Jenis Izin
                        </label>
                        <select id="permissionType" class="border rounded-lg w-full px-3 py-2">
                            <option value="sick">Sakit</option>
                            <option value="leave">Cuti</option>
                            <option value="business">Dinas Luar</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="permissionDate">
                            Tanggal
                        </label>
                        <input type="date" id="permissionDate" class="border rounded-lg w-full px-3 py-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="permissionNote">
                            Keterangan
                        </label>
                        <textarea id="permissionNote" rows="3" class="border rounded-lg w-full px-3 py-2" placeholder="Berikan keterangan..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Lampiran
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-500">Seret file ke sini atau klik untuk mengunggah</p>
                            <input type="file" class="hidden" id="fileUpload">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelPermission" class="px-4 py-2 border rounded-lg text-sm font-medium hover:bg-gray-100">
                            Batal
                        </button>
                        <button type="submit" class="bg-[#580720] hover:bg-[#800020] text-white px-4 py-2 rounded-lg text-sm font-medium">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Real-time Clock
        function updateClock() {
            const now = new Date();
            const date = now.toLocaleDateString('id-ID', { 
                weekday: 'long', 
                day: 'numeric', 
                month: 'long', 
                year: 'numeric' 
            });
            const time = now.toLocaleTimeString('id-ID');
            document.getElementById('realTimeClock').innerHTML = `${date} - ${time}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Camera Access
        const video = document.getElementById('video');
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(err => {
                    console.error("Error accessing camera: ", err);
                    alert("Tidak dapat mengakses kamera. Pastikan Anda memberikan izin.");
                });
        }

        // Capture Button
        document.getElementById('captureBtn').addEventListener('click', () => {
            alert("Absen masuk berhasil direkam!");
            // Here you would typically capture the image and send to server
        });

        document.getElementById('captureOutBtn').addEventListener('click', () => {
            alert("Absen pulang berhasil direkam!");
            // Here you would typically capture the image and send to server
        });

        // Permission Modal
        const permissionModal = document.getElementById('permissionModal');
        document.getElementById('permissionBtn').addEventListener('click', () => {
            permissionModal.classList.remove('hidden');
        });

        document.getElementById('closeModal').addEventListener('click', () => {
            permissionModal.classList.add('hidden');
        });

        document.getElementById('cancelPermission').addEventListener('click', () => {
            permissionModal.classList.add('hidden');
        });

        // File Upload Interaction
        const fileUpload = document.getElementById('fileUpload');
        const uploadArea = fileUpload.previousElementSibling;
        
        uploadArea.addEventListener('click', () => {
            fileUpload.click();
        });

        fileUpload.addEventListener('change', () => {
            if (fileUpload.files.length > 0) {
                uploadArea.innerHTML = `
                    <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                    <p class="text-sm text-gray-700">${fileUpload.files[0].name}</p>
                    <p class="text-xs text-gray-500">${(fileUpload.files[0].size / 1024).toFixed(2)} KB</p>
                `;
            }
        });
    </script>
</body>
</html>