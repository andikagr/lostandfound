@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
        <div>
            <h2 class="page-title mb-1">Riwayat Klaim Barang</h2>
            <p class="text-muted mb-0">Kelola dan pantau semua riwayat pengajuan klaim barang.</p>
        </div>
        <div>
            <span class="badge" style="background-color: #e31837; font-size: 14px; padding: 10px 16px; border-radius: 50px;">
                Total: {{ $claims->count() }} Klaim
            </span>
        </div>
    </div>

    <div class="premium-card bg-transparent shadow-none p-0">
        <div class="row g-4">
            @forelse($claims as $claim)
                <div class="col-12">
                    <div class="premium-card p-0 overflow-hidden" style="transition: transform 0.2s;">
                        <div class="d-flex flex-column flex-md-row">
                            <!-- GAMBAR -->
                            <div class="bg-light border-end" style="width:180px; height:180px; flex-shrink:0;">
                                @php
                                    $item = $claim->foundItem ?? $claim->lostItem;
                                @endphp
                                @if($item && $item->image)
                                    <img src="{{ (str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image)) }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="h-100 d-flex flex-column align-items-center justify-content-center text-muted small">
                                        <i class="bi bi-image fs-2 mb-2"></i>
                                        <span>No Image</span>
                                    </div>
                                @endif
                            </div>

                            <!-- INFO BARANG & PEMILIK -->
                            <div class="flex-grow-1 p-4">
                                <div class="row align-items-center h-100">
                                    <div class="col-md-5 mb-3 mb-md-0 border-end-md">
                                        <div class="mb-2">
                                            @if($claim->foundItem)
                                                <span class="badge rounded-pill bg-info bg-opacity-10 text-info mb-1 px-3 py-1 border border-info border-opacity-25">
                                                    <i class="bi bi-box-seam me-1"></i> Barang Temuan
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary mb-1 px-3 py-1 border border-secondary border-opacity-25">
                                                    <i class="bi bi-search me-1"></i> Barang Hilang
                                                </span>
                                            @endif
                                            
                                            <h5 class="fw-bold text-dark mt-2 mb-1">
                                                {{ $item->nama_barang ?? 'Barang tidak tersedia' }}
                                            </h5>
                                        </div>
                                        <div class="text-secondary small mb-2 text-dark fw-medium">
                                            <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                                            {{ ($claim->foundItem ? $claim->foundItem->lokasi : $claim->lostItem->lokasi_terakhir) ?? '-' }}
                                        </div>
                                        <div class="text-secondary small mb-0 text-muted">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            Diajukan: {{ $claim->created_at->format('d M Y') }}
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3 mb-md-0 ps-md-4">
                                        <h6 class="fw-bold text-muted small text-uppercase mb-3" style="letter-spacing: 0.5px;">Informasi Pengklaim</h6>
                                        <div class="mb-2 text-dark fs-6">
                                            <i class="bi bi-person-circle text-primary me-2"></i><strong>{{ $claim->nama_pemilik }}</strong>
                                        </div>
                                        <div class="mb-0 text-dark fs-6">
                                            <i class="bi bi-telephone text-success me-2"></i>{{ $claim->kontak_pemilik }}
                                        </div>
                                        <div class="mt-3">
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill fs-6">
                                                <i class="bi bi-check-circle-fill me-1"></i> {{ strtoupper($claim->status ?? 'DIKLAIM') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- AKSI (Hanya Admin) -->
                                    <div class="col-md-3 text-md-end">
                                        @if(auth()->check() && auth()->user()->role === 'admin')
                                            <div class="d-flex flex-md-column gap-2 justify-content-start justify-content-md-end h-100">
                                                <a href="{{ route('claim-items.edit', $claim->id) }}" class="btn btn-light text-warning border fw-bold px-3 py-2 ms-auto w-100 mb-2">
                                                    <i class="bi bi-pencil-square me-2"></i> Edit Status
                                                </a>
                                                <form action="{{ route('claim-items.destroy', $claim->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat klaim ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light text-danger border fw-bold px-3 py-2 ms-auto w-100">
                                                        <i class="bi bi-trash me-2"></i> Hapus Klaim
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="premium-card p-5">
                        <i class="bi bi-clipboard-x display-1" style="color:#dadddf;"></i>
                        <p class="mt-3 text-muted fs-5 fw-medium">Belum ada riwayat klaim yang ditemukan.</p>
                        <a href="{{ route('found-items.index') }}" class="btn btn-primary-custom mt-3">
                            <i class="bi bi-box-seam me-1"></i> Lihat Barang Temuan
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection