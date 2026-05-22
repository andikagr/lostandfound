@extends('layouts.app')

@section('title', 'Detail Barang Ditemukan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Detail Barang Ditemukan</h2>
            <p class="text-muted mb-0">Informasi lengkap mengenai barang yang ditemukan.</p>
        </div>
        <div>
            <a href="{{ route('found-items.index') }}" class="btn btn-outline-secondary px-4 fw-medium rounded-pill border-2">
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
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0">
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
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1 mb-2 border border-danger border-opacity-10">
                                <i class="bi bi-box-seam me-1"></i> Barang Temuan
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
                                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Lokasi Penemuan</h6>
                                    <div class="fw-semibold text-dark">{{ $item->lokasi_penemuan ?? '-' }}</div>
                                    <div class="small text-muted mt-1">{{ $item->lokasi ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex gap-3">
                                <div class="text-danger fs-3"><i class="bi bi-calendar-event"></i></div>
                                <div>
                                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Waktu Ditemukan</h6>
                                    <div class="fw-semibold text-dark">
                                        {{ $item->tanggal_ditemukan ? $item->tanggal_ditemukan->format('d F Y') : '-' }}
                                    </div>
                                    <div class="small text-muted mt-1">{{ $item->waktu_ditemukan ? $item->waktu_ditemukan . ' WIB' : '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 pb-4 border-bottom">
                        <h6 class="text-muted small text-uppercase fw-bold mb-2">Kronologi & Deskripsi</h6>
                        <p class="text-dark mb-3" style="line-height: 1.6;">
                            <strong>Kronologi:</strong> <br>
                            {{ $item->kronologi ?? 'Tidak ada kronologi yang dicatat.' }}
                        </p>
                        <p class="text-dark mb-0" style="line-height: 1.6;">
                            <strong>Deskripsi Tambahan:</strong> <br>
                            {{ $item->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted small text-uppercase fw-bold mb-3">Informasi Penemu</h6>
                        <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-3 border">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:50px; height:50px;">
                                <i class="bi bi-person-fill text-primary fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $item->nama_penemu ?? 'Anonim' }}</div>
                                <div class="small text-muted mb-1"><i class="bi bi-telephone me-1"></i> Kontak: {{ $item->kontak_penemu ?? '-' }} / {{ $item->kontak ?? '-' }}</div>
                                <div class="small text-muted"><i class="bi bi-house me-1"></i> Alamat: {{ $item->alamat_penemu ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-end mt-5 pt-3 border-top">
                        @can('admin-only')
                            <a href="{{ route('found-items.edit', $item->id) }}" class="btn btn-outline-custom">
                                <i class="bi bi-pencil-square me-1"></i> Ubah Data
                            </a>
                        @endcan
                        <a href="{{ route('claim-items.create', $item->id) }}" class="btn btn-primary-custom px-4 shadow-sm">
                            <i class="bi bi-check2-circle me-1"></i> Ajukan Klaim
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection