<div class="sidebar fixed top-0 left-0 h-screen bg-white rounded-r-xl shadow-xl w-[220px] transition-all duration-300 border-r border-gray-100" id="sidebar">
  <!-- Logo and Header -->
  <div class="p-4 text-center">
    <div class="stars">
      <span class="text-yellow-500">★</span>
      <span class="text-yellow-500">★</span>
      <span class="text-yellow-500">★</span>
      <span class="text-yellow-500">★</span>
      <span class="text-yellow-500">★</span>
    </div>
    <h1 class="text-xl font-extrabold text-[#580720] tracking-tight sidebar-logo">GENPRO</h1>
    <div class="border-b-2 border-black mt-3 mb-4 mx-4"></div>
    <div class="flex flex-col space-y-1 px-2">
      <!-- Menu Items -->
      <a href="/dashboard" class="flex items-center p-3 font-bold text-[0.9rem] text-[#580720] hover:bg-gradient-to-r from-[#580720] to-[#800020] hover:text-white rounded-lg transition-all duration-200 group <?php echo (request()->is('dashboard')) ? 'bg-gradient-to-r from-[#580720] to-[#800020] text-white' : ''; ?>">
        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <rect x="3" y="3" width="7" height="7" rx="1" />
          <rect x="14" y="3" width="7" height="7" rx="1" />
          <rect x="3" y="14" width="7" height="7" rx="1" />
          <rect x="14" y="14" width="7" height="7" rx="1" />
        </svg>
        <span class="text-left">Dashboard</span>
      </a>
      
      <?php if(auth()->user()->role !== 'mentee'): ?>
        <!-- Menu untuk admin, mentor, secretary, kepalaSekolah -->
        <a href="/formulir" class="flex items-center p-3 font-bold text-[0.9rem] text-[#580720] hover:bg-gradient-to-r from-[#580720] to-[#800020] hover:text-white rounded-lg transition-all duration-200 group <?php echo (request()->is('formulir')) ? 'bg-gradient-to-r from-[#580720] to-[#800020] text-white' : ''; ?>">
          <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
          </svg>
          <span class="text-left">Mente</span>
        </a>

        <a href="/daftar-compeny" class="flex items-center p-3 font-bold text-[0.9rem] text-[#580720] hover:bg-gradient-to-r from-[#580720] to-[#800020] hover:text-white rounded-lg transition-all duration-200 group <?php echo (request()->is('daftar-compeny')) ? 'bg-gradient-to-r from-[#580720] to-[#800020] text-white' : ''; ?>">
          <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
          </svg>
          <span class="text-left">Daftar Company</span>
        </a>
        
        <a href="/Summary-financial-admin" class="flex items-center p-3 font-bold text-[0.9rem] text-[#580720] hover:bg-gradient-to-r from-[#580720] to-[#800020] hover:text-white rounded-lg transition-all duration-200 group <?php echo (request()->is('Summary-Financial-admin')) ? 'bg-gradient-to-r from-[#580720] to-[#800020] text-white' : ''; ?>">
          <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
            <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
          </svg>
          <span class="text-left">Summary Financial</span>
        </a>      
        
        <!-- <a href="/finance-report" class="flex items-center p-3 font-bold text-[0.9rem] text-[#580720] hover:bg-gradient-to-r from-[#580720] to-[#800020] hover:text-white rounded-lg transition-all duration-200 group <?php echo (request()->is('finance-report')) ? 'bg-gradient-to-r from-[#580720] to-[#800020] text-white' : ''; ?>">
          <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <span class="text-left">Financial Report</span>
        </a> -->

        <a href="/mutabaah-admin" class="flex items-center p-3 font-bold text-[0.9rem] text-[#580720] hover:bg-gradient-to-r from-[#580720] to-[#800020] hover:text-white rounded-lg transition-all duration-200 group <?php echo (request()->is('mutabaah')) ? 'bg-gradient-to-r from-[#580720] to-[#800020] text-white' : ''; ?>">
          <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 4h16v2H4V4zm0 5h16v2H4V9zm0 5h10v2H4v-2z" />
          </svg>
          <span class="text-left">Laporan Mutabaah</span>
        </a>

        <a href="/daftar-kelas" class="flex items-center p-3 font-bold text-[0.9rem] text-[#580720] hover:bg-gradient-to-r from-[#580720] to-[#800020] hover:text-white rounded-lg transition-all duration-200 group <?php echo (request()->is('daftar-kelas')) ? 'bg-gradient-to-r from-[#580720] to-[#800020] text-white' : ''; ?>">
          <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87M12 12a4 4 0 100-8 4 4 0 000 8z" />
          </svg>
          <span class="text-left">Daftar Kelas</span>
        </a>
      <?php else: ?>
        <!-- Menu khusus untuk mentee -->
        <a href="/kelas-mente" class="flex items-center p-3 font-bold text-[0.9rem] text-[#580720] hover:bg-gradient-to-r from-[#580720] to-[#800020] hover:text-white rounded-lg transition-all duration-200 group <?php echo (request()->is('kelas-mente')) ? 'bg-gradient-to-r from-[#580720] to-[#800020] text-white' : ''; ?>">
          <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M4 6h16M4 10h16M4 14h10M4 18h10" />
          </svg>
          <span class="text-left">Kelas</span>
        </a>

        <a href="{{ route('summary-financial') }}" class="flex items-center p-3 font-bold text-[0.9rem] text-[#580720] hover:bg-gradient-to-r from-[#580720] to-[#800020] hover:text-white rounded-lg transition-all duration-200 group <?php echo (request()->is('Summary-Financial')) ? 'bg-gradient-to-r from-[#580720] to-[#800020] text-white' : ''; ?>">
          <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
            <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
          </svg>
          <span class="text-left">Summary Financial</span>
        </a>

        <a href="/mentee-mutabaah" class="flex items-center p-3 font-bold text-[0.9rem] text-[#580720] hover:bg-gradient-to-r from-[#580720] to-[#800020] hover:text-white rounded-lg transition-all duration-200 group <?php echo (request()->is('mutabaah-mente')) ? 'bg-gradient-to-r from-[#580720] to-[#800020] text-white' : ''; ?>">
          <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M5 13l4 4L19 7" />
          </svg>
          <span class="text-left">Mutabaah</span>
        </a>

        <a href="/profile-mente" class="flex items-center p-3 font-bold text-[0.9rem] text-[#580720] hover:bg-gradient-to-r from-[#580720] to-[#800020] hover:text-white rounded-lg transition-all duration-200 group <?php echo (request()->is('profile-mente')) ? 'bg-gradient-to-r from-[#580720] to-[#800020] text-white' : ''; ?>">
          <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
          </svg>
          <span class="text-left">Profile Saya</span>
        </a>

        <a href="/absen" class="flex items-center p-3 font-bold text-[0.9rem] text-[#580720] hover:bg-gradient-to-r from-[#580720] to-[#800020] hover:text-white rounded-lg transition-all duration-200 group <?php echo (request()->is('daftar-kelas')) ? 'bg-gradient-to-r from-[#580720] to-[#800020] text-white' : ''; ?>">
          <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87M12 12a4 4 0 100-8 4 4 0 000 8z" />
          </svg>
          <span class="text-left">Absensi</span>
        </a>

      <?php endif; ?>
    </div>
  </div>
  
  <!-- Spacer to push sign out to bottom -->
  <div class="flex-grow"></div>
  
  <!-- Sign Out Button -->
  <div class="absolute bottom-4 w-full px-4">
    <button class="w-full bg-gradient-to-r from-[#580720] to-[#800020] text-white p-3 rounded-lg flex items-center justify-center hover:opacity-90 transition-all duration-200 shadow-md hover:shadow-lg font-semibold sidebar-signout">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
      </svg>
      <span class="signout-text">Sign Out</span>
    </button>
  </div>
  <script>
    // Get the sidebar sign out button
const sidebarSignoutButton = document.querySelector('.sidebar-signout');

// Add event listener to the sidebar sign out button
sidebarSignoutButton.addEventListener('click', async function(e) {
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
  </script>
</div>