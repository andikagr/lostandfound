@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
        <div>
            <h2 class="page-title mb-1">Barang Hilang</h2>
            <p class="text-muted mb-0">Daftar laporan barang yang hilang dari pengguna.</p>
        </div>
        <div>
            <a href="{{ route('lost-items.create') }}" class="btn btn-primary-custom">
                <i class="bi bi-file-earmark-plus me-1"></i> Buat Laporan Kehilangan
            </a>
        </div>
    </div>

    <div class="premium-card mb-4">
        <form method="GET" action="{{ route('lost-items.index') }}" id="searchForm">
            <div class="d-flex flex-column flex-md-row gap-3 align-items-md-end">
                <div class="flex-grow-1">
                    <div class="input-group" style="border: 2px solid #e31837; border-radius: 50px; overflow: hidden;">
                        <span class="input-group-text border-0 bg-white ps-3"><i class="bi bi-search text-danger"></i></span>
                        <input type="text" name="search" class="form-control border-0 shadow-none py-2" 
                               placeholder="Cari nama barang..." value="{{ request('search') }}" 
                               style="font-size: 15px;">
                        @if(request()->hasAny(['search', 'kategori', 'lokasi', 'tanggal_dari', 'tanggal_sampai']))
                            <a href="{{ route('lost-items.index') }}" class="btn btn-light border-0 px-3" title="Reset">
                                <i class="bi bi-x-lg text-muted"></i>
                            </a>
                        @endif
                        <button type="submit" class="btn border-0 px-4 fw-bold text-white" style="background-color: #e31837;">
                            Cari
                        </button>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-custom px-3" data-bs-toggle="collapse" data-bs-target="#advancedFilter">
                    <i class="bi bi-funnel me-1"></i> Filter
                    @if(request()->hasAny(['kategori', 'lokasi', 'tanggal_dari', 'tanggal_sampai']))
                        <span class="badge bg-danger rounded-circle ms-1">!</span>
                    @endif
                </button>
            </div>

            <div class="collapse {{ request()->hasAny(['kategori', 'lokasi', 'tanggal_dari', 'tanggal_sampai']) ? 'show' : '' }}" id="advancedFilter">
                <div class="row g-3 mt-2 pt-3 border-top">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Kategori</label>
                        <select name="kategori" class="form-select form-select-sm" onchange="document.getElementById('searchForm').submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Lokasi</label>
                        <select name="lokasi" class="form-select form-select-sm" onchange="document.getElementById('searchForm').submit()">
                            <option value="">Semua Lokasi</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc }}" {{ request('lokasi') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Dari Tanggal</label>
                        <input type="date" name="tanggal_dari" class="form-select form-select-sm" 
                               value="{{ request('tanggal_dari') }}" onchange="document.getElementById('searchForm').submit()">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Sampai Tanggal</label>
                        <input type="date" name="tanggal_sampai" class="form-select form-select-sm" 
                               value="{{ request('tanggal_sampai') }}" onchange="document.getElementById('searchForm').submit()">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="premium-card">
        <div class="table-responsive">
            <table class="table table-custom mb-0 w-100">
                <thead>
                    <tr>
                        <th width="120" class="text-center">Gambar</th>
                        <th>Info Barang</th>
                        <th>Lokasi Laporan</th>
                        <th width="280" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td class="text-center">
                                <div class="bg-light rounded mx-auto" style="width: 80px; height: 80px; overflow: hidden;">
                                    @if($item->image)
                                        <img src="{{ (str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image)) }}"
                                             class="w-100 h-100 object-fit-cover"
                                             alt="{{ $item->nama_barang }}"
                                             onerror="this.onerror=null;this.src='https://via.placeholder.com/80?text=No+Img';">
                                    @else
                                        <div class="h-100 d-flex flex-column align-items-center justify-content-center text-muted small">
                                            <i class="bi bi-image fs-4 mb-1"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <h6 class="fw-bold mb-1 text-dark">{{ $item->nama_barang }}</h6>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1">
                                    Status: Terlapor
                                </span>
                            </td>
                            
                            <td>
                                <div class="mb-1 text-dark fw-medium">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $item->lokasi_terakhir }}
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @auth
                                        <a href="{{ route('claim-items.create-for-lost', $item->id) }}" class="btn action-btn" style="background-color:#18e33e; color:white;">
                                            <i class="bi bi-hand-index-thumb me-1"></i> Saya Menemukan
                                        </a>
                                    @endauth

                                    <a href="{{ route('lost-items.show', $item) }}" class="btn btn-light text-primary action-btn border px-3">
                                        Detail
                                    </a>
                                    
                                    @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->id() === $item->user_id))
                                        <div class="dropdown">
                                            <button class="btn btn-light border action-btn rounded-circle px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                <li><a class="dropdown-item text-warning fw-medium" href="{{ route('lost-items.edit', $item) }}"><i class="bi bi-pencil-square me-2"></i>Edit</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('lost-items.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini secara permanen?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger fw-medium"><i class="bi bi-trash me-2"></i>Hapus</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted d-flex flex-column align-items-center">
                                    <i class="bi bi-journal-x display-4 mb-3" style="color:#dadddf;"></i>
                                    <span class="fs-5 fw-medium">Belum ada laporan barang hilang.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if(method_exists($items, 'links'))
                <div class="mt-4 d-flex justify-content-end">
                    {{ $items->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection