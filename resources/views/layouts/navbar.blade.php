<div class="flex flex-col">
  <!-- Navbar -->
  <div class="navbar bg-[#580720] text-white h-[35vh] rounded-b-lg">
    <div class="container mx-auto flex justify-between items-center p-3">
      <div class="flex items-center">
        <!-- Hamburger menu -->
        <button id="sidebarToggle" class="text-white-600 hover:text-white-900 p-2">
          <i data-lucide="menu"></i>
       </button>
      </div>
      
      <!-- User info -->
      <div class="relative">
        <button id="user-menu-button" class="flex items-center focus:outline-none">
          <span class="mr-2">Hi, Administrator</span>
          <i data-lucide="chevron-down" id="chevron-icon" class="w-4 h-4 transition-transform"></i>
        </button>
        
        <!-- Dropdown menu -->
        <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
          <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" id="logout-button">
            <div class="flex items-center">
              <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
              Logout
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <div class="p-4">
    <!-- Your page content goes here -->
  </div>
</div>

<!-- Tambahkan di head atau sebelum tag script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
    
    // Element references
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');
    const chevronIcon = document.getElementById('chevron-icon');
    const logoutButton = document.getElementById('logout-button');
    
    // Toggle dropdown
    userMenuButton.addEventListener('click', function(e) {
      e.stopPropagation();
      userDropdown.classList.toggle('hidden');
      chevronIcon.classList.toggle('rotate-180');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function() {
      userDropdown.classList.add('hidden');
      chevronIcon.classList.remove('rotate-180');
    });
    
    // Logout handler
    logoutButton.addEventListener('click', async function(e) {
    e.preventDefault();
    
    // Konfirmasi logout
    const confirmResult = await Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Apakah Anda yakin ingin logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#580720',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Logout!',
        cancelButtonText: 'Batal',
        allowOutsideClick: false,
        allowEscapeKey: false
    });
    
    if (!confirmResult.isConfirmed) return;
    
    // Tampilkan loading
    Swal.fire({
        title: 'Memproses logout...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    try {
        // Dapatkan token dari localStorage
        const authToken = localStorage.getItem('auth_token');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        // Lakukan request logout
        const response = await fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            credentials: 'include'
        });
        
        // Jika response tidak OK, lempar error
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Logout gagal');
        }
        
        // Hapus token dari localStorage
        localStorage.removeItem('auth_token');
        
        // Tampilkan notifikasi sukses
        await Swal.fire({
            title: 'Logout Berhasil!',
            text: 'Anda akan diarahkan ke halaman login',
            icon: 'success',
            confirmButtonColor: '#580720',
            timer: 1500,
            timerProgressBar: true,
            willClose: () => {
                window.location.href = '/';
            }
        });
        
    } catch (error) {
        // Tutup loading dialog
        Swal.close();
        
        // Tampilkan error hanya jika halaman belum di-redirect
        if (!window.location.href.includes('/login')) {
            await Swal.fire({
                title: 'Error!',
                text: error.message,
                icon: 'error',
                confirmButtonColor: '#580720'
            });
        }
    }
});
  });
</script>