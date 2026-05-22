<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CariU - Temukan Barang Hilang</title>
    <!-- Use Google Fonts (Inter) for modern typography -->
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
            background-color: #f4f5f8;
            display: flex;
            align-items: stretch;
            min-height: 100vh;
            overflow: hidden;
        }

        /* ----- ANIMATIONS ----- */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-15px) scale(1.02); }
            100% { transform: translateY(0px) scale(1); }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Container split */
        .container {
            display: flex;
            width: 100%;
            position: relative;
        }

        /* Left Content Area */
        .left-content {
            flex: 1;
            padding: 5% 8%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: relative;
            z-index: 10;
        }

        /* ====== LOGO ====== */
        .brand-logo {
            height: 120px;
            width: auto;
            object-fit: contain;
            margin-bottom: 15vh;
            animation: fadeInUp 0.8s ease-out forwards;
            mix-blend-mode: multiply;
        }

        /* Headlines */
        .headline {
            font-size: 56px;
            font-weight: 800;
            color: #2b3040;
            line-height: 1.2;
            margin-bottom: 24px;
            max-width: 600px;
            opacity: 0;
            animation: fadeInUp 0.8s ease-out 0.2s forwards;
        }
        .headline span {
            color: #d81b3f;
        }

        /* Paragraph */
        .description {
            font-size: 18px;
            color: #4a5065;
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 480px;
            opacity: 0;
            animation: fadeInUp 0.8s ease-out 0.4s forwards;
        }

        /* Button */
        .cta-button {
            display: inline-block;
            background-color: #d81b3f;
            color: white;
            font-weight: 700;
            font-size: 16px;
            padding: 16px 36px;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 6px 20px rgba(216, 27, 63, 0.3);
            border: none;
            cursor: pointer;
            width: fit-content;
            opacity: 0;
            animation: fadeInUp 0.8s ease-out 0.6s forwards;
        }
        
        .cta-button:hover {
            background-color: #ba1333;
            transform: translateY(-4px) scale(1.05); /* Springy hover */
            box-shadow: 0 10px 25px rgba(216, 27, 63, 0.5);
        }

        /* Right Content Area (Illustration) */
        .right-content {
            flex: 1;
            position: relative;
            background-color: #e5e7eb; /* Soft grey frame background */
            display: flex;
            align-items: flex-end; /* Align image to bottom */
            justify-content: center;
            opacity: 0;
            animation: slideInRight 1s ease-out 0.3s forwards;
            box-shadow: inset 15px 0 30px rgba(0,0,0,0.03); /* subtle inner shadow */
        }

        /* Dark wedge in the background right corner */
        .dark-wedge {
            position: absolute;
            top: 0;
            right: 0;
            width: 350px;
            height: 100%;
            background-color: #8990a0;
            clip-path: polygon(100% 0, 100% 100%, 0 100%);
            z-index: 1;
        }

        /* The actual illustration image */
        .illustration-img {
            max-width: 130%;
            height: 90vh; /* Make it large but not full screen height to show frame */
            object-fit: contain;
            object-position: bottom;
            z-index: 2;
            pointer-events: none;
            filter: drop-shadow(-10px 10px 20px rgba(0,0,0,0.15));
            animation: float 6s ease-in-out infinite; /* Floating animation */
        }

        @media (max-width: 900px) {
            body { overflow: auto; }
            .container { flex-direction: column; }
            .left-content {
                padding-top: 60px;
                padding-bottom: 60px;
                text-align: center;
                align-items: center;
            }
            .logo { margin-bottom: 40px; }
            .headline { font-size: 36px; }
            .right-content {
                min-height: 500px;
                overflow: hidden;
            }
            .dark-wedge { display: none; }
            .illustration-img { max-width: 100%; height: auto; }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Left Side: Text and CTA -->
        <div class="left-content">
            <img src="{{ asset('images/cariu_logo_asli.png') }}" class="brand-logo" alt="CariU Logo" style="mix-blend-mode: multiply;">

            <h1 class="headline">
                <span>Temukan Barang</span> Hilang <br>
                dengan <span>Lebih Mudah!</span>
            </h1>

            <p class="description">
                Kini CariU hadir menjembatani kebutuhan kamu jika kehilangan atau menemukan barang yang hilang
            </p>

            @auth
                <a href="{{ route('found-items.index') }}" class="cta-button">Mulai Sekarang</a>
            @else
                <a href="{{ route('login') }}" class="cta-button">Mulai Sekarang</a>
            @endauth
        </div>

        <!-- Right Side: Framed Illustration with Dark Wedge -->
        <div class="right-content">
            <div class="dark-wedge"></div>
            <!-- We continue to use the same background asset, but styled dynamically -->
            <img src="{{ asset('images/telkom_student.png') }}" alt="Mahasiswa Telkom" class="illustration-img" onerror="this.style.display='none'">
        </div>
    </div>

</body>
</html>
