<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - CariU</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f6f9;
        }

        /* NAVBAR */
        .navbar {
            background-color: #0d6efd;
            color: white;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
        }

        /* CONTAINER */
        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: calc(100vh - 60px);
            padding-top: 90px;
        }

        /* CARD */
        .card {
            background: white;
            width: 480px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        }

        .card h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 26px;
        }

        /* FORM */
        input {
            width: 100%;
            padding: 14px;
            margin-bottom: 18px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #0d6efd;
            border: none;
            color: white;
            font-size: 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0b5ed7;
        }

        .error {
            background-color: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-size: 15px;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 15px;
        }

        .login-link a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <div class="navbar">
        Welcome To CariU
    </div>

    <!-- REGISTER FORM -->
    <div class="container">
        <div class="card">
            <h2>Register</h2>

            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf
                <input type="text" name="name" placeholder="Nama Lengkap" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>

            <div class="login-link">
                Sudah punya akun?
                <a href="/login">Login</a>
            </div>
        </div>
    </div>

</body>
</html>