<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CariU - Dashboard</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="shortcut icon" href="/favicon.svg">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800;900&family=Montserrat:wght@900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f4f6;
            color: #2b3040;
        }

        /* PREMIUM NAVBAR */
        .navbar-custom {
            background-color: #e31837;
            padding: 15px 30px;
            box-shadow: 0 4px 12px rgba(227, 24, 55, 0.2);
        }

        /* ====== NAVBAR LOGO ====== */
        .brand-logo-nav {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .brand-logo-nav:hover {
            opacity: 0.85;
        }

        .brand-logo-nav img {
            height: 55px;
            width: auto;
        }

        .nav-link-custom {
            color: rgba(255,255,255,0.8);
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s;
            text-decoration: none;
            margin: 0 4px;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            color: #ffffff;
            background-color: rgba(255,255,255,0.15);
        }

        .user-badge {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-logout {
            background-color: white;
            color: #e31837;
            border: none;
            font-weight: 700;
            border-radius: 50px;
            padding: 6px 16px;
            transition: all 0.2s;
        }
        .btn-logout:hover {
            background-color: #ffe6e6;
            transform: scale(1.05);
        }

        /* CARD STYLING */
        .premium-card {
            background: white;
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 24px;
        }

        .page-title {
            font-weight: 800;
            color: #2b3040;
            font-size: 24px;
        }

        /* BUTTONS */
        .btn-primary-custom {
            background-color: #e31837;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: background 0.2s;
        }
        .btn-primary-custom:hover {
            background-color: #c91430;
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid #e31837;
            color: #e31837;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 20px;
            transition: all 0.2s;
            background: transparent;
        }
        
        .btn-outline-custom:hover {
            background-color: #e31837;
            color: white;
        }

        /* TABLE STYLING */
        .table-custom {
            margin-top: 20px;
        }
        
        .table-custom thead th {
            font-weight: 700;
            color: #6c757d;
            border-bottom-width: 1px;
            background-color: #f8f9fa;
            border-top: none;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
            padding: 16px;
        }

        .table-custom tbody td {
            vertical-align: middle;
            color: #2b3040;
            font-size: 15px;
            padding: 16px;
            border-bottom: 5px solid white; /* visual separation */
            background-color: #ffffff;
        }

        .table-custom tbody tr {
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            border-radius: 8px;
        }
        
        /* Action Buttons in Table */
        .action-btn {
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <!-- Logo -->
            <a href="/" class="brand-logo-nav">
                <img src="{{ asset('images/cariu_logo_asli_white.png') }}" alt="CariU Logo">
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="filter: invert(1) brightness(2);">
                <span class="navbar-toggler-icon"></span>
            </button>

            @auth
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto ms-4">
                    <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                    <a href="{{ route('found-items.index') }}" class="nav-link-custom {{ request()->is('found-items*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam me-1"></i> Barang Ditemukan
                    </a>
                    <a href="{{ route('lost-items.index') }}" class="nav-link-custom {{ request()->is('lost-items*') ? 'active' : '' }}">
                        <i class="bi bi-search me-1"></i> Barang Hilang
                    </a>
                    <a href="{{ route('riwayat.index') }}" class="nav-link-custom {{ request()->is('riwayat*') ? 'active' : '' }}">
                        <i class="bi bi-clock-history me-1"></i> Riwayat
                    </a>
                </div>

                <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                    <!-- Notification Bell -->
                    @php
                        $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
                    @endphp
                    <div class="dropdown">
                        <a href="#" class="position-relative text-white text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 20px;">
                            <i class="bi bi-bell-fill"></i>
                            @if($unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark" style="font-size: 10px;">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0" style="width: 340px; max-height: 400px; overflow-y: auto; border-radius: 12px;">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom" style="background: linear-gradient(135deg, #e31837, #c41230); border-radius: 12px 12px 0 0;">
                                <h6 class="mb-0 text-white fw-bold"><i class="bi bi-bell me-1"></i> Notifikasi</h6>
                                @if($unreadCount > 0)
                                    <a href="{{ route('notifications.read-all') }}" class="text-white small text-decoration-none opacity-75">Tandai semua</a>
                                @endif
                            </div>
                            @php
                                $notifications = \App\Models\Notification::where('user_id', Auth::id())->latest()->take(10)->get();
                            @endphp
                            @forelse($notifications as $notif)
                                <a href="{{ route('notifications.read', $notif->id) }}" class="dropdown-item px-3 py-2 {{ !$notif->is_read ? 'bg-danger bg-opacity-10' : '' }}" style="white-space: normal; border-bottom: 1px solid #f0f0f0;">
                                    <div class="d-flex gap-2">
                                        <div class="mt-1">
                                            @if($notif->type === 'claim_new')
                                                <i class="bi bi-hand-index-thumb-fill text-warning"></i>
                                            @elseif($notif->type === 'claim_approved')
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            @elseif($notif->type === 'item_match')
                                                <i class="bi bi-stars text-primary"></i>
                                            @else
                                                <i class="bi bi-info-circle-fill text-info"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-medium small text-dark">{{ $notif->title }}</div>
                                            <div class="text-muted small text-truncate" style="max-width: 260px;">{{ $notif->message }}</div>
                                            <div class="text-muted" style="font-size: 11px;"><i class="bi bi-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-bell-slash fs-3 d-block mb-2"></i>
                                    <small>Belum ada notifikasi</small>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="user-badge">
                        <i class="bi bi-person-circle fs-5"></i>
                        <span>{{ Auth::user()->name }}</span>
                        @if(Auth::user()->isAdmin())
                            <span class="badge bg-warning text-dark ms-1">ADMIN</span>
                        @endif
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button class="btn btn-logout" type="submit">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container-fluid px-4 px-lg-5 my-5">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; background-color:#e8fce8; color:#18e33e; border:1px solid #caf8ca;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px; background-color:#fce8e8; color:#e31837; border:1px solid #f8caca;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>