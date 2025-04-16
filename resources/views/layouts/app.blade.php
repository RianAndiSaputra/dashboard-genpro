<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GENPRO - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .content {
            margin-left: 120px;
        }
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .yellow-card {
            background-color: #FFBF00; /* Warna emas */
            color: white;
        }
        .pink-card {
            background-color: #E3256B; /* Warna pink */
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Sidebar Component -->
    @include('layouts.sidebar')

    <!-- Content Area -->
    <div class="content">
        <!-- Navbar Component -->
        @include('layouts.navbar')

        <!-- Main Content -->
        <div class="p-6">
            @yield('content')
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>