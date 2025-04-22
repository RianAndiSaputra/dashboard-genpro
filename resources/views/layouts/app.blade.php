<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GENPRO - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            background-color: #f3f4f6; /* Warna background default Tailwind */
        }
        
        /* Layout Utama */
        .main-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Area Konten */
        .content-area {
            flex-grow: 1;
            margin-left: 220px; /* Sesuai lebar sidebar */
            transition: margin-left 0.3s;
            position: relative;
        }
        
        /* Ketika Sidebar Collapsed */
        .sidebar-collapsed .content-area {
            margin-left: 60px;
        }
        
        /* Navbar Positioning */
        .navbar-container {
            position: relative; /* Diubah dari fixed ke relative */
            height: 25vh;
            z-index: 15;
        }
        
        /* Konten Utama yang Naik ke Atas */
        .main-content {
            margin-top: -80px; /* Nilai negatif untuk naik ke atas */
            padding: 1rem;
            position: relative;
            z-index: 20; /* Pastikan di atas navbar */
            /* background-color: #f3f4f6; */
            /* border-top-left-radius: 20px;
            border-top-right-radius: 20px; */
            box-shadow: 0 -5px 15px rgba(0,0,0,0.1);
        }
        
        /* Card Styling */
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1rem;
            background-color: white;
        }
        
        .yellow-card {
            background-color: #FFBF00;
            color: white;
        }
        
        .pink-card {
            background-color: #E3256B;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="main-layout" id="mainLayout">
        <!-- Sidebar Component -->
        @include('layouts.sidebar')

        <div class="content-area">
            <!-- Navbar -->
            <div class="navbar-container">
                @include('layouts.navbar')
            </div>
            
            <!-- Main Content - Naik Menimpa Navbar -->
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Sidebar toggle functionality
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mainLayout = document.getElementById('mainLayout');
        
        sidebarToggle.addEventListener('click', () => {
            mainLayout.classList.toggle('sidebar-collapsed');
        });

        document.addEventListener('DOMContentLoaded', function() {
    // Tambahkan token ke setiap request AJAX
    let token = localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
    
    if (token) {
        // Untuk fetch API
        let originalFetch = window.fetch;
        window.fetch = function(url, options = {}) {
            if (!options.headers) {
                options.headers = {};
            }
            
            // Tambahkan Authorization header jika belum ada
            if (!options.headers.Authorization) {
                options.headers.Authorization = `Bearer ${token}`;
            }
            
            return originalFetch(url, options);
        };
        
        // Untuk XMLHttpRequest
        let originalOpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function() {
            let method = arguments[0];
            let url = arguments[1];
            originalOpen.apply(this, arguments);
            this.setRequestHeader('Authorization', `Bearer ${token}`);
        };
    }
});

    </script>
</body>
</html>