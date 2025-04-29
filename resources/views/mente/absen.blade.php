<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Absensi Real-time</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #video {
            transform: scaleX(-1); /* Mirror effect for camera */
        }
        .attendance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        #canvas {
            display: none;
        }
        .location-info {
            max-height: 100px;
            overflow-y: auto;
        }
        /* SweetAlert Customization */
        .swal2-popup {
            border-radius: 0.75rem !important;
        }
        .swal2-title {
            color: #580720 !important;
            font-weight: bold !important;
        }
        .swal2-confirm {
            background-color: #580720 !important;
        }
        .swal2-styled:focus {
            box-shadow: 0 0 0 3px rgba(88, 7, 32, 0.3) !important;
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
                                <canvas id="canvas"></canvas>
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
                            <div class="text-center">
                                <button id="captureBtn" class="bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-bold transition w-full">
                                    <i class="fas fa-camera mr-2"></i> Absen Masuk
                                </button>
                            </div>
                            <div id="locationStatus" class="text-sm text-gray-600 mt-2">
                                <div class="flex items-center">
                                    <i class="fas fa-location-dot mr-2 text-blue-500"></i>
                                    <span>Mendapatkan lokasi...</span>
                                </div>
                            </div>
                            <div id="locationDetails" class="text-sm bg-gray-100 p-3 rounded-lg location-info hidden">
                                <p class="font-medium">Lokasi Terdeteksi:</p>
                                <p id="addressDisplay" class="text-gray-700"></p>
                                <p class="mt-1">
                                    <a id="mapLink" href="#" target="_blank" class="text-blue-600 hover:underline">
                                        <i class="fas fa-map-marker-alt mr-1"></i> Lihat di Maps
                                    </a>
                                </p>
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
                            <div class="mb-6">
                                <h3 class="text-lg font-bold text-[#580720]">
                                    <i class="fas fa-user-circle mr-2"></i>
                                    {{ auth()->user()->full_name ?? auth()->user()->name }} - Riwayat Absensi Pribadi
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Total Absensi: {{ $attendances->count() }}</p>
                            </div>

                            <!-- Attendance List -->
                            <div id="attendanceList" class="space-y-3">
                                @forelse($attendances as $attendance)
                                    @php
                                        $checkInTime = \Carbon\Carbon::parse($attendance['check_in_time']);
                                        $locationInfo = $attendance['location_info']['location_info'] ?? null;
                                        $address = $locationInfo['address'] ?? 'Lokasi tidak tersedia';
                                        $mapLink = $locationInfo['map_link'] ?? '#';
                                        $menteeName = $attendance['location_info']['mentee']['user']['full_name'] ?? 'Nama tidak tersedia';
                                    @endphp
                                    <div class="attendance-card bg-white border rounded-lg p-4 hover:shadow-md transition cursor-pointer"
                                        data-selfie="{{ $attendance['selfie_url'] }}"
                                        data-date="{{ $checkInTime->translatedFormat('l, d F Y') }}"
                                        data-time="{{ $checkInTime->format('H:i:s') }}"
                                        data-address="{{ $address }}"
                                        data-maplink="{{ $mapLink }}">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-start space-x-3">
                                                <div class="bg-green-100 text-green-800 rounded-full p-2">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold">Absen Masuk</h3>
                                                    <p class="text-sm text-gray-600">
                                                        {{ $checkInTime->translatedFormat('l, d F Y') }}
                                                    </p>
                                                    <p class="text-sm text-gray-600">
                                                        Pukul {{ $checkInTime->format('H:i:s') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-medium">
                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                    {{ Str::limit($address, 30) }}
                                                </p>
                                                <button class="view-photo text-blue-600 hover:text-blue-800 text-sm mt-1">
                                                    <i class="fas fa-image mr-1"></i> Lihat Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-500">
                                        <i class="fas fa-calendar-xmark text-2xl mb-2"></i>
                                        <p>Belum ada riwayat absensi</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // CSRF Token for Laravel
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Current user info
        const menteeId = {{ auth()->user()->menteeProfile->id ?? 'null' }};
        
        // API Endpoints
        const API = {
            getAttendances: 'http://127.0.0.1:8000/api/history/absen',
            storeAttendance: 'http://127.0.0.1:8000/api/create/absen'
        };
        
        // Global variables for geolocation
        let currentPosition = null;
        let isCapturing = false;
        
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

        // Get location 
        function getLocation() {
            const locationStatus = document.getElementById('locationStatus');
            const locationDetails = document.getElementById('locationDetails');
            
            if (!navigator.geolocation) {
                locationStatus.innerHTML = '<div class="text-red-500"><i class="fas fa-exclamation-circle mr-2"></i>Geolokasi tidak didukung oleh browser Anda</div>';
                Swal.fire({
                    icon: 'error',
                    title: 'Geolokasi Tidak Didukung',
                    text: 'Browser Anda tidak mendukung fitur geolokasi',
                    confirmButtonColor: '#580720'
                });
                return;
            }
            
            locationStatus.innerHTML = '<div class="flex items-center"><i class="fas fa-spinner fa-spin mr-2 text-blue-500"></i><span>Mendapatkan lokasi...</span></div>';
            
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    currentPosition = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    };
                    
                    locationStatus.innerHTML = '<div class="flex items-center text-green-600"><i class="fas fa-check-circle mr-2"></i><span>Lokasi berhasil diambil</span></div>';
                    
                    document.getElementById('mapLink').href = `https://www.google.com/maps?q=${currentPosition.latitude},${currentPosition.longitude}`;
                    document.getElementById('addressDisplay').textContent = 'Mendapatkan detail alamat...';
                    locationDetails.classList.remove('hidden');
                },
                (error) => {
                    console.error("Error getting location", error);
                    let errorMessage = 'Gagal mendapatkan lokasi';
                    
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Izin akses lokasi ditolak. Silakan aktifkan di pengaturan browser.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Informasi lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'Waktu untuk mendapatkan lokasi habis.';
                            break;
                    }
                    
                    locationStatus.innerHTML = `<div class="text-red-500"><i class="fas fa-exclamation-circle mr-2"></i>${errorMessage}</div>`;
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Mendapatkan Lokasi',
                        text: errorMessage,
                        confirmButtonColor: '#580720'
                    });
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        }

        // Camera Access
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        
        async function setupCamera() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    video.srcObject = stream;
                    
                    video.addEventListener('loadedmetadata', () => {
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                    });
                    
                    getLocation();
                } catch (err) {
                    console.error("Error accessing camera: ", err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Akses Kamera Gagal',
                        text: 'Tidak dapat mengakses kamera. Pastikan Anda memberikan izin.',
                        confirmButtonColor: '#580720'
                    });
                }
            }
        }
        
        setupCamera();
        
        function capturePhotoAsDataURL() {
            return new Promise((resolve) => {
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
                resolve(dataUrl);
            });
        }
        
        // Submit attendance
        async function submitAttendance() {
            if (isCapturing) return;
            
            if (!currentPosition) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Lokasi Belum Tersedia',
                    text: 'Mohon tunggu atau aktifkan izin lokasi.',
                    confirmButtonColor: '#580720'
                });
                return;
            }

            if (menteeId === 'null') {
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak',
                    text: "Anda belum terdaftar sebagai mentee",
                    confirmButtonColor: '#580720'
                });
                return;
            }
            
            // Show confirmation dialog
            const { isConfirmed } = await Swal.fire({
                title: 'Konfirmasi Absensi',
                text: "Anda yakin ingin melakukan absen masuk sekarang?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#580720',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Absen Sekarang',
                cancelButtonText: 'Batal'
            });
            
            if (!isConfirmed) return;
            
            try {
                isCapturing = true;
                document.getElementById('captureBtn').disabled = true;
                document.getElementById('captureBtn').innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
                
                // Show processing alert
                Swal.fire({
                    title: 'Memproses Absensi',
                    html: 'Mohon tunggu sebentar...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Capture photo
                const selfieDataUrl = await capturePhotoAsDataURL();
                
                // Current timestamp
                const now = new Date();
                const checkInTime = now.toISOString().slice(0, 19).replace('T', ' ');
                
                // Prepare data for API
                const attendanceData = {
                    mentee_id: menteeId,
                    check_in_time: checkInTime,
                    selfie_url: selfieDataUrl,
                    latitude: currentPosition.latitude,
                    longitude: currentPosition.longitude
                };
                
                // Send to API
                const response = await fetch(API.storeAttendance, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(attendanceData)
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "Absensi berhasil dicatat!",
                        confirmButtonColor: '#580720',
                        timer: 3000,
                        timerProgressBar: true
                    }).then(() => {
                        if (result.data && result.data.location_info) {
                            const locationInfo = result.data.location_info;
                            document.getElementById('addressDisplay').textContent = locationInfo.address || 'Alamat tidak tersedia';
                        }
                        loadAttendances();
                    });
                } else {
                    throw new Error(result.message || 'Failed to record attendance');
                }
            } catch (error) {
                console.error("Error submitting attendance:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: "Gagal mencatat absensi: " + error.message,
                    confirmButtonColor: '#580720'
                });
            } finally {
                isCapturing = false;
                document.getElementById('captureBtn').disabled = false;
                document.getElementById('captureBtn').innerHTML = '<i class="fas fa-camera mr-2"></i> Absen Masuk';
                Swal.close();
            }
        }
        
        // Load attendances from API
        async function loadAttendances() {
            try {
                const attendanceListElement = document.getElementById('attendanceList');
                if (!attendanceListElement) {
                    console.error('Element with ID "attendanceList" not found');
                    return;
                }
                
                attendanceListElement.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>Memuat data absensi...</p>
                    </div>
                `;
                
                const response = await fetch(API.getAttendances, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error with status: ${response.status}`);
                }
                
                const result = await response.json();
                const attendances = result.data || [];
                
                if (attendances.length === 0) {
                    attendanceListElement.innerHTML = `
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-calendar-xmark text-2xl mb-2"></i>
                            <p>Belum ada data absensi</p>
                        </div>
                    `;
                    return;
                }
                
                const attendanceElements = attendances.map(attendance => {
                    const checkInTime = new Date(attendance.check_in_time);
                    const formattedDate = checkInTime.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    const formattedTime = checkInTime.toLocaleTimeString('id-ID');
                    
                    const locationInfo = attendance.location_info?.location_info || {};
                    const address = locationInfo.address || 'Lokasi tidak tersedia';
                    const mapLink = locationInfo.map_link || `https://www.google.com/maps?q=${attendance.latitude},${attendance.longitude}`;
                    
                    return `
                        <div class="attendance-card bg-white border rounded-lg p-4 hover:shadow-md transition cursor-pointer"
                            data-selfie="${attendance.selfie_url || ''}"
                            data-date="${formattedDate}"
                            data-time="${formattedTime}"
                            data-address="${address}"
                            data-maplink="${mapLink}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-3">
                                    <div class="bg-green-100 text-green-800 rounded-full p-2">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold">Absen Masuk</h3>
                                        <p class="text-sm text-gray-600">${formattedDate}</p>
                                        <p class="text-sm text-gray-600">${formattedTime}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        ${address.substring(0, 30)}${address.length > 30 ? '...' : ''}
                                    </p>
                                    <button class="view-photo text-blue-600 hover:text-blue-800 text-sm mt-1">
                                        <i class="fas fa-image mr-1"></i> Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
                
                attendanceListElement.innerHTML = attendanceElements;
                
                // Add event listeners to view photos
                document.querySelectorAll('.view-photo, .attendance-card').forEach(element => {
                    element.addEventListener('click', function(e) {
                        if (this.classList.contains('view-photo')) {
                            e.preventDefault();
                            e.stopPropagation();
                        }
                        
                        const card = this.classList.contains('attendance-card') ? this : this.closest('.attendance-card');
                        openPhotoModal(
                            card.dataset.selfie, 
                            card.dataset.date, 
                            card.dataset.time, 
                            card.dataset.address,
                            card.dataset.maplink
                        );
                    });
                });
                
            } catch (error) {
                console.error("Error loading attendances:", error);
                const attendanceListElement = document.getElementById('attendanceList');
                if (attendanceListElement) {
                    attendanceListElement.innerHTML = `
                        <div class="text-center py-8 text-red-500">
                            <i class="fas fa-exclamation-circle text-2xl mb-2"></i>
                            <p>Gagal memuat data absensi</p>
                            <p class="text-sm mt-2">${error.message}</p>
                        </div>
                    `;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memuat Data',
                    text: 'Tidak dapat memuat riwayat absensi',
                    confirmButtonColor: '#580720'
                });
            }
        }

        // Photo modal using SweetAlert
        function openPhotoModal(imageUrl, date, time, address, mapLink) {
            Swal.fire({
                title: 'Detail Absensi',
                html: `
                    <div class="text-left space-y-2 text-sm">
                        <img src="${imageUrl}" alt="Selfie Absensi" class="w-full rounded-lg shadow-md mb-4">
                        <p><span class="font-medium">Tanggal:</span> ${date}</p>
                        <p><span class="font-medium">Waktu:</span> ${time}</p>
                        <p><span class="font-medium">Alamat:</span> ${address}</p>
                        <p><span class="font-medium">Lokasi:</span> 
                            <a href="${mapLink}" target="_blank" class="text-blue-600 hover:underline">Lihat di Maps</a>
                        </p>
                    </div>
                `,
                width: '600px',
                padding: '2em',
                color: '#4b5563',
                background: '#fff',
                confirmButtonColor: '#580720',
                showCloseButton: true
            });
        }
        
        // Event Listeners
        document.getElementById('captureBtn').addEventListener('click', submitAttendance);
        
        // Load attendances on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadAttendances();
        });
    </script>
</body>
</html>