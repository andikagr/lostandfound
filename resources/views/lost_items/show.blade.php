@extends('layouts.app')

@section('title', 'Detail Laporan Barang Hilang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Detail Barang Hilang</h2>
        <p class="text-muted mb-0">Informasi lengkap terkait laporan kehilangan barang.</p>
    </div>
    <div>
        <a href="{{ route('lost-items.index') }}" class="btn btn-outline-secondary px-4 fw-medium rounded-pill border-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<div class="premium-card p-0 overflow-hidden">
    <div class="row g-0">
        <!-- Left Side: Image -->
        <div class="col-md-5 col-lg-4 bg-light position-relative">
            <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="min-height: 400px;">
                @if($item->image)
                    <img src="{{ (str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image)) }}" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" alt="{{ $item->nama_barang }}">
                @else
                    <div class="text-center text-muted">
                        <i class="bi bi-image" style="font-size: 4rem; opacity: 0.5;"></i>
                        <p class="mt-2 fw-medium">Tidak ada foto tersedia</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Side: Details -->
        <div class="col-md-7 col-lg-8">
            <div class="p-4 p-lg-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1 mb-2 border border-secondary border-opacity-10">
                            <i class="bi bi-search me-1"></i> Laporan Kehilangan
                        </span>
                        <h3 class="fw-bold text-dark mb-0 fs-2" style="letter-spacing: -0.5px;">{{ $item->nama_barang }}</h3>
                        <div class="text-muted mt-1 fw-medium">{{ $item->kategori ?? 'Kategori Tidak Disebutkan' }}</div>
                    </div>
                </div>

                <div class="row gx-5 gy-4 mb-4 pb-4 border-bottom">
                    <div class="col-sm-6">
                        <div class="d-flex gap-3">
                            <div class="text-danger fs-3"><i class="bi bi-geo-alt-fill"></i></div>
                            <div>
                                <h6 class="text-muted small text-uppercase fw-bold mb-1">Lokasi Terakhir</h6>
                                <div class="fw-semibold text-dark">{{ $item->lokasi_terakhir ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3">
                            <div class="text-danger fs-3"><i class="bi bi-calendar-event"></i></div>
                            <div>
                                <h6 class="text-muted small text-uppercase fw-bold mb-1">Tanggal Hilang</h6>
                                <div class="fw-semibold text-dark">
                                    {{ $item->tanggal_hilang ? $item->tanggal_hilang->format('d F Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 pb-4 border-bottom">
                    <h6 class="text-muted small text-uppercase fw-bold mb-2">Deskripsi & Ciri Khusus</h6>
                    <p class="text-dark mb-0" style="line-height: 1.6;">
                        {{ $item->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}
                    </p>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted small text-uppercase fw-bold mb-3">Informasi Kontak</h6>
                    <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-3 border">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:50px; height:50px;">
                            <i class="bi bi-telephone text-success fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Nomor yang Dapat Dihubungi</div>
                            <div class="small text-muted mb-1">{{ $item->kontak ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-end mt-5 pt-3 border-top flex-wrap">
                    @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->id() === $item->user_id))
                        <form action="{{ route('lost-items.destroy', $item->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                        <a href="{{ route('lost-items.edit', $item->id) }}" class="btn btn-outline-warning">
                            <i class="bi bi-pencil-square me-1"></i> Ubah Data
                        </a>
                    @endif
                    
                    @auth
                        <a href="{{ route('claim-items.create-for-lost', $item->id) }}" class="btn btn-primary-custom px-4 shadow-sm" style="background-color: #18e33e;">
                            <i class="bi bi-hand-index-thumb me-1"></i> Saya Menemukan Barang Ini
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection