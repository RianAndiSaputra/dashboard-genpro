<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GENPRO - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SweetAlert2 CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #440519;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            background-image: linear-gradient(135deg, #2c0210 0%, #2c000d 100%);
        }
        
        .login-container {
            background-color: white;
            border-radius: 16px;
            padding: 32px;
            width: 100%;
            max-width: 320px;
            box-shadow: 
                0 4px 6px rgba(0, 0, 0, 0.1),
                0 1px 3px rgba(0, 0, 0, 0.08),
                0 15px 32px rgba(0, 0, 0, 0.3),
                0 15px 30px rgba(88, 7, 32, 0.2);
            position: relative;
            animation: fadeIn 0.5s ease-in-out;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transform: translateY(0);
            z-index: 1;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .logo {
            text-align: center;
            margin-bottom: 24px;
        }
        
        .logo-text {
            color: #580720;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        
        .stars {
            color: #FFD700;
            font-size: 18px;
            margin-bottom: 8px;
            letter-spacing: 2px;
            text-shadow: 0 0 5px rgba(255, 215, 0, 0.3);
        }
        
        .form-title {
            text-align: center;
            color: #333;
            font-size: 14px;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 16px;
        }
        
        input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 14px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        
        input:focus {
            outline: none;
            border-color: #580720;
            box-shadow: 0 0 0 2px rgba(88, 7, 32, 0.1);
        }
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #580720;
        }
        
        .login-button {
            width: 100%;
            background-color: #580720;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 12px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 8px rgba(88, 7, 32, 0.2);
        }
        
        .login-button:hover {
            background-color: #400518;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(88, 7, 32, 0.3);
        }
        
        .login-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(88, 7, 32, 0.3);
        }
        
        .input-error {
            border-color: #dc3545;
        }
        
        .loader {
            border: 3px solid #f3f3f3;
            border-radius: 50%;
            border-top: 3px solid #580720;
            width: 20px;
            height: 20px;
            margin-left: 10px;
            animation: spin 1s linear infinite;
            display: none;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .loading .loader {
            display: inline-block;
        }
        
        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 7px 14px rgba(0, 0, 0, 0.1),
                0 3px 6px rgba(0, 0, 0, 0.08),
                0 20px 40px rgba(0, 0, 0, 0.4),
                0 20px 38px rgba(88, 7, 32, 0.25);
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 16px;
            padding: 1px;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(88,7,32,0.1) 100%);
            -webkit-mask: 
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <div class="stars">
                <span class="text-yellow-500">★</span>
                <span class="text-yellow-500">★</span>
                <span class="text-yellow-500">★</span>
                <span class="text-yellow-500">★</span>
                <span class="text-yellow-500">★</span>
            </div>
            <div class="logo-text">GENPRO</div>
        </div>
        
        <div class="form-title">FORM LOGIN</div>
        
        <form id="login-form">
            @csrf
            <div class="input-group">
                <input type="text" id="username" name="username" placeholder="Username or Email" required>
            </div>
            
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span class="password-toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                    </svg>
                </span>
            </div>
            
            <button type="submit" id="login-button" class="login-button">
                Login
                <span class="loader"></span>
            </button>
        </form>
    </div>

    <script>
        // Toggle password visibility
        document.querySelector('.password-toggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                    </svg>
                `;
            } else {
                passwordInput.type = 'password';
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                    </svg>
                `;
            }
        });
        
        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (!username || !password) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please fill in all fields!',
                    confirmButtonColor: '#580720',
                });
                
                if (!username) document.getElementById('username').classList.add('input-error');
                if (!password) document.getElementById('password').classList.add('input-error');
                return;
            }
            
            document.getElementById('username').classList.remove('input-error');
            document.getElementById('password').classList.remove('input-error');
            
            const loginButton = document.getElementById('login-button');
            loginButton.disabled = true;
            loginButton.classList.add('loading');
            
            try {
                // Get CSRF token from meta tag
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ username, password })
                });
                
                const data = await response.json();
                
                console.log('Login response:', data); // Debugging
                
                if (response.ok && data.status) {
                    // Simpan token di localStorage dan sessionStorage
                    localStorage.setItem('auth_token', data.access_token);
                    sessionStorage.setItem('auth_token', data.access_token);
                    
                    // Simpan juga di cookie untuk lebih aman (httpOnly cookie tidak bisa diakses via js)
                    document.cookie = `auth_token=${data.access_token}; path=/; secure; samesite=strict`;
                    
                    // Tampilkan alert sukses
                    await Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        text: 'Mengarahkan ke dashboard...',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    });
                    
                    // Redirect ke dashboard dengan auth header
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Login failed');
                }
            } catch (error) {
                console.error('Login error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: error.message || 'Terjadi kesalahan saat login',
                    confirmButtonColor: '#580720',
                });
            } finally {
                loginButton.disabled = false;
                loginButton.classList.remove('loading');
            }
        });
        
        // Input event listeners to remove error styling when typing
        document.getElementById('username').addEventListener('input', function() {
            this.classList.remove('input-error');
        });
        
        document.getElementById('password').addEventListener('input', function() {
            this.classList.remove('input-error');
        });
        
        // Check for login error in session (from redirect)
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '{{ session('error') }}',
                confirmButtonColor: '#580720',
            });
        @endif
        
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonColor: '#580720',
            });
        @endif
    </script>
</body>
</html>