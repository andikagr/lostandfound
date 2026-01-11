<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CariU</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid px-4 d-flex align-items-center">

            <a class="navbar-brand fw-bold mb-0" href="/">
                Welcome To CariU
            </a>

            @auth
                <div class="ms-auto d-flex align-items-center gap-2">
                    <a href="{{ route('lost-items.index') }}" class="btn btn-outline-light btn-sm">
                        Barang Hilang
                    </a>
                    <a href="{{ route('found-items.index') }}" class="btn btn-outline-light btn-sm">
                        Barang Ditemukan
                    </a>
                    <a href="{{ route('riwayat.index') }}" class="btn btn-outline-light btn-sm">
                        Riwayat
                    </a>

                    <div class="text-white mx-2 d-flex align-items-center gap-1">
                        <span>{{ Auth::user()->name }}</span>
                        @if(Auth::user()->isAdmin())
                            <span class="badge bg-warning text-dark text-uppercase">ADMIN</span>
                        @else
                            <span class="badge bg-secondary text-uppercase">USER</span>
                        @endif
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button class="btn btn-danger btn-sm" type="submit">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth

        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container-fluid px-4 my-4">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>