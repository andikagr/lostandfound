<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - CariU</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="shortcut icon" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Poppins:wght@600;700;800;900&family=Montserrat:wght@900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            min-height: 100vh;
            background-color: #ffffff;
        }

        /* Left Split - Red Branding */
        .split-left {
            flex: 4;
            background-color: #e31837;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            flex-direction: column;
            gap: 16px;
        }

        /* ====== LOGO ====== */
        .brand-logo-login {
            height: 180px;
            width: auto;
        }

        .brand-tagline {
            font-family: 'Inter', sans-serif;
            color: rgba(255,255,255,0.75);
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 16px;
        }

        /* Right Split - Register Form */
        .split-right {
            flex: 5;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            padding: 40px 0;
        }

        .login-box {
            width: 100%;
            max-width: 650px;
            padding: 60px;
        }

        .login-title {
            color: #e31837;
            font-size: 64px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 60px;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 36px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 16px;
            color: #1a1a1a;
            font-weight: 600;
            font-size: 20px;
        }

        .form-control {
            width: 100%;
            padding: 24px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            font-size: 20px;
            transition: all 0.3s;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: #e31837;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            display: flex;
            align-items: center;
        }

        .register-link {
            font-size: 16px;
            margin-bottom: 32px;
            color: #555;
            margin-top: 10px;
        }

        .register-link a {
            color: #e31837;
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 24px;
            background-color: #e31837;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 24px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
            margin-top: 40px;
        }

        .btn-submit:hover {
            background-color: #c91430;
        }

        /* Alerts */
        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-error {
            background-color: #fce8e8;
            color: #e31837;
            border: 1px solid #f8caca;
        }
        .alert-success {
            background-color: #e8fce8;
            color: #18e33e;
            border: 1px solid #caf8ca;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .split-left {
                flex: none;
                height: 250px;
            }
            .split-right {
                flex: 1;
                align-items: flex-start;
                padding-top: 40px;
            }
        }
    </style>
</head>
<body>

    <div class="split-left">
        <img src="{{ asset('images/cariu_logo_asli_white.png') }}" class="brand-logo-login" alt="CariU Logo">
        <div class="brand-tagline">Temukan Barang Hilang</div>
    </div>

    <div class="split-right">
        <div class="login-box">
            <h1 class="login-title">Daftar</h1>

            @if ($errors->any())
                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama Anda" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password_input" class="form-control" placeholder="Masukkan password Anda" required>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <!-- Eye crossed SVG -->
                            <svg id="eye_closed" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                            <!-- Eye open SVG (hidden by default) -->
                            <svg id="eye_open" style="display: none;" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>

                <div class="register-link">
                    Sudah memiliki akun? <a href="/login">Masuk Sekarang</a>
                </div>

                <button type="submit" class="btn-submit">Daftar</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            var input = document.getElementById("password_input");
            var eyeClosed = document.getElementById("eye_closed");
            var eyeOpen = document.getElementById("eye_open");
            if (input.type === "password") {
                input.type = "text";
                eyeClosed.style.display = "none";
                eyeOpen.style.display = "block";
            } else {
                input.type = "password";
                eyeClosed.style.display = "block";
                eyeOpen.style.display = "none";
            }
        }
    </script>
</body>
</html>
