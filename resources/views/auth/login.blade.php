<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GENPRO - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #440519; /* Dark maroon background */
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
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: fadeIn 0.5s ease-in-out;
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
            color: #580720; /* Dark maroon color */
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        
        .stars {
            color: #FFD700; /* Gold color for stars */
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
            background-color: #580720; /* Dark maroon */
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
        
        /* Alert styles */
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            display: none;
        }
        
        .alert.show {
            opacity: 1;
            transform: translateY(0);
            display: flex;
            align-items: center;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #810a16;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }
        
        .alert-icon {
            margin-right: 10px;
            font-size: 16px;
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
            0 15px 30px rgba(88, 7, 32, 0.2); /* Shadow dengan sentuhan warna maroon */
        position: relative;
        animation: fadeIn 0.5s ease-in-out;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1); /* Border halus untuk efek premium */
        transform: translateY(0);
        z-index: 1;
    }
    
    /* Efek hover yang halus */
    .login-container:hover {
        transform: translateY(-5px);
        box-shadow: 
            0 7px 14px rgba(0, 0, 0, 0.1),
            0 3px 6px rgba(0, 0, 0, 0.08),
            0 20px 40px rgba(0, 0, 0, 0.4),
            0 20px 38px rgba(88, 7, 32, 0.25);
    }
    
    /* Efek sebelum untuk kesan lebih dalam */
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
        <!-- Alert containers -->
        <div id="alert-success" class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span class="alert-message">Login successful! Redirecting...</span>
        </div>
        
        <div id="alert-error" class="alert alert-error">
            <span class="alert-icon">✕</span>
            <span class="alert-message">Invalid username or password.</span>
        </div>
        
        <div id="alert-warning" class="alert alert-warning">
            <span class="alert-icon">!</span>
            <span class="alert-message">Please fill in all fields.</span>
        </div>
        
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
            <div class="input-group">
                <input type="text" id="username" placeholder="username">
            </div>
            
            <div class="input-group">
                <input type="password" id="password" placeholder="password">
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
            } else {
                passwordInput.type = 'password';
            }
        });
        
        // Login form handling
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            
            // Hide any existing alerts
            hideAllAlerts();
            
            // Validate inputs
            if (!username || !password) {
                showAlert('warning', 'Please fill in all fields.');
                
                // Highlight empty fields
                if (!username) document.getElementById('username').classList.add('input-error');
                if (!password) document.getElementById('password').classList.add('input-error');
                
                return;
            }
            
            // Remove any error styling
            document.getElementById('username').classList.remove('input-error');
            document.getElementById('password').classList.remove('input-error');
            
            // Show loading state
            const loginButton = document.getElementById('login-button');
            loginButton.disabled = true;
            loginButton.classList.add('loading');
            
            // Simulate login process (replace with actual authentication)
            setTimeout(function() {
                // For demonstration, check if username is "admin" and password is "password"
                if (username === 'admin' && password === 'password') {
                    showAlert('success', 'Login successful! Redirecting...');
                    
                    // Redirect after 1 second (replace with actual redirect)
                    setTimeout(function() {
                        window.location.href = '/dashboard';
                    }, 1000);
                } else {
                    showAlert('error', 'Invalid username or password.');
                    loginButton.disabled = false;
                    loginButton.classList.remove('loading');
                }
            }, 1500);
        });
        
        // Input event listeners to remove error styling when typing
        document.getElementById('username').addEventListener('input', function() {
            this.classList.remove('input-error');
            hideAllAlerts();
        });
        
        document.getElementById('password').addEventListener('input', function() {
            this.classList.remove('input-error');
            hideAllAlerts();
        });
        
        // Alert handling functions
        function showAlert(type, message) {
            hideAllAlerts();
            
            const alertId = 'alert-' + type;
            const alertElement = document.getElementById(alertId);
            
            if (alertElement) {
                alertElement.querySelector('.alert-message').textContent = message;
                alertElement.classList.add('show');
                
                // Auto hide non-success alerts after 5 seconds
                if (type !== 'success') {
                    setTimeout(function() {
                        alertElement.classList.remove('show');
                    }, 5000);
                }
            }
        }
        
        function hideAllAlerts() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.classList.remove('show');
            });
        }
    </script>
</body>
</html>