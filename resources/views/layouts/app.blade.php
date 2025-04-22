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
        html.preload #sidebar {
            display: none;
        }

        body {
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            background-color: #f3f4f6;
        }

        .main-layout {
            display: flex;
            min-height: 100vh;
        }

        .content-area {
            flex-grow: 1;
            margin-left: 220px;
            transition: margin-left 0.3s;
            position: relative;
        }

        .sidebar-collapsed .content-area {
            margin-left: 100px;
        }

        .navbar-container {
            position: relative;
            height: 25vh;
            z-index: 15;
        }

        .main-content {
            margin-top: -80px;
            padding: 1rem;
            position: relative;
            z-index: 20;
            box-shadow: 0 -5px 15px rgba(0,0,0,0.1);
        }

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

        #sidebar {
            width: 220px;
            transition: all 0.3s ease;
        }

        .sidebar-collapsed #sidebar {
            width: 90px;
        }

        .sidebar-collapsed .sidebar-logo,
        .sidebar-collapsed .sidebar span,
        .sidebar-collapsed .signout-text {
            display: none;
        }

        .sidebar-collapsed .sidebar svg {
            margin-right: 0;
        }
    </style>
</head>

<body class="bg-gray-100" id="mainLayout">
    <div class="main-layout" id="mainLayout">
        @include('layouts.sidebar')

        <div class="content-area">
            <div class="navbar-container">
                @include('layouts.navbar')
            </div>

            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Hilangkan preload supaya sidebar bisa muncul sesuai localStorage
        window.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.remove('preload');

            const html = document.documentElement;
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Cek localStorage dan terapkan class collapsed
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                html.classList.add('sidebar-collapsed');
            }

            // Toggle listener
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    html.classList.toggle('sidebar-collapsed');
                    const isNowCollapsed = html.classList.contains('sidebar-collapsed');
                    localStorage.setItem('sidebarCollapsed', isNowCollapsed);
                });
            }

            // Inisialisasi ikon lucide
            lucide.createIcons();
        });

        function openInputModal(id) {
        document.getElementById('inputModal').classList.remove('hidden');
    }

    function closeInputModal() {
        document.getElementById('inputModal').classList.add('hidden');
    }
    </script>
</body>
</html>