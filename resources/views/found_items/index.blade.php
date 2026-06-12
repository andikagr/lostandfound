@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
        <div>
            <h2 class="page-title mb-1">Barang Ditemukan</h2>
            <p class="text-muted mb-0">Daftar semua barang yang telah ditemukan dan dilaporkan ke sistem.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('found-items.print') }}" target="_blank" class="btn btn-outline-custom">
                <i class="bi bi-printer me-1"></i> Cetak / PDF
            </a>
            <a href="{{ route('form-found-items.create') }}" class="btn btn-primary-custom">
                <i class="bi bi-plus-lg me-1"></i> Tambah Barang
            </a>
        </div>
    </div>

    <div class="premium-card mb-4">
        <form method="GET" action="{{ route('found-items.index') }}" id="searchForm">
            <div class="d-flex flex-column flex-md-row gap-3 align-items-md-end">
                <!-- Search Bar -->
                <div class="flex-grow-1">
                    <div class="input-group" style="border: 2px solid #e31837; border-radius: 50px; overflow: hidden;">
                        <span class="input-group-text border-0 bg-white ps-3"><i class="bi bi-search text-danger"></i></span>
                        <input type="text" name="search" class="form-control border-0 shadow-none py-2" 
                               placeholder="Cari nama barang..." value="{{ request('search') }}" 
                               style="font-size: 15px;">
                        @if(request()->hasAny(['search', 'kategori', 'lokasi', 'tanggal_dari', 'tanggal_sampai']))
                            <a href="{{ route('found-items.index') }}" class="btn btn-light border-0 px-3" title="Reset">
                                <i class="bi bi-x-lg text-muted"></i>
                            </a>
                        @endif
                        <button type="submit" class="btn border-0 px-4 fw-bold text-white" style="background-color: #e31837;">
                            Cari
                        </button>
                    </div>
                </div>
                <!-- Toggle Filter -->
                <button type="button" class="btn btn-outline-custom px-3" data-bs-toggle="collapse" data-bs-target="#advancedFilter">
                    <i class="bi bi-funnel me-1"></i> Filter
                    @if(request()->hasAny(['kategori', 'lokasi', 'tanggal_dari', 'tanggal_sampai']))
                        <span class="badge bg-danger rounded-circle ms-1">!</span>
                    @endif
                </button>
            </div>

            <!-- Advanced Filters (collapsible) -->
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
                        <th width="50" class="text-center">No</th>
                        <th width="100">Gambar</th>
                        <th>Info Barang</th>
                        <th>Lokasi & Penemu</th>
                        <th width="280" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $i => $item)
                        <tr>
                            <td class="text-center fw-semibold text-muted">{{ $i + 1 }}</td>
                            <td>
                                <div class="bg-light rounded" style="width: 80px; height: 80px; overflow: hidden;">
                                    <img src="{{ $item->image ? (str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image)) : 'https://via.placeholder.com/80' }}" 
                                         class="w-100 h-100 object-fit-cover" 
                                         alt="{{ $item->nama_barang }}"
                                         onerror="this.onerror=null;this.src='https://via.placeholder.com/80?text=No+Img';">
                                </div>
                            </td>
                            <td>
                                <h6 class="fw-bold mb-1 text-dark">{{ $item->nama_barang }}</h6>
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    {{ $item->tanggal_ditemukan ? $item->tanggal_ditemukan->format('d M Y') : '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="mb-1 text-dark fw-medium">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $item->lokasi_penemuan }}
                                </div>
                                <div class="small text-muted">
                                    <i class="bi bi-person-circle me-1"></i> {{ $item->nama_penemu }}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('found-items.show', $item->id) }}" class="btn btn-light text-primary action-btn border">
                                        Detail
                                    </a>
                                    
                                    <a href="{{ route('claim-items.create', $item->id) }}" class="btn btn-success action-btn">
                                        <i class="bi bi-check2-circle me-1"></i> Klaim
                                    </a>

                                    @can('admin-only')
                                        <div class="dropdown">
                                            <button class="btn btn-light border action-btn rounded-circle px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                <li><a class="dropdown-item text-warning fw-medium" href="{{ route('found-items.edit', $item->id) }}"><i class="bi bi-pencil-square me-2"></i>Edit</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('found-items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini secara permanen?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item text-danger fw-medium"><i class="bi bi-trash me-2"></i>Hapus</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted d-flex flex-column align-items-center">
                                    <i class="bi bi-box2-heart display-4 mb-3" style="color:#dadddf;"></i>
                                    <span class="fs-5 fw-medium">Belum ada barang ditemukan</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection