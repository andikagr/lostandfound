@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h2 class="page-title mb-1">Dashboard</h2>
        <p class="text-muted mb-0">Overview statistik CariU - Lost & Found</p>
    </div>

    <!-- STAT CARDS -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-6">
            <div class="premium-card text-center position-relative overflow-hidden" style="border-left: 4px solid #2196F3;">
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <i class="bi bi-box-seam" style="font-size: 48px; color: #2196F3;"></i>
                </div>
                <h3 class="fw-bold mb-1" style="font-size: 36px; color: #2196F3;">{{ $totalFound }}</h3>
                <p class="text-muted mb-0 fw-medium small">Barang Ditemukan</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="premium-card text-center position-relative overflow-hidden" style="border-left: 4px solid #e31837;">
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <i class="bi bi-search" style="font-size: 48px; color: #e31837;"></i>
                </div>
                <h3 class="fw-bold mb-1" style="font-size: 36px; color: #e31837;">{{ $totalLost }}</h3>
                <p class="text-muted mb-0 fw-medium small">Barang Hilang</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="premium-card text-center position-relative overflow-hidden" style="border-left: 4px solid #FF9800;">
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <i class="bi bi-hand-index-thumb" style="font-size: 48px; color: #FF9800;"></i>
                </div>
                <h3 class="fw-bold mb-1" style="font-size: 36px; color: #FF9800;">{{ $totalClaims }}</h3>
                <p class="text-muted mb-0 fw-medium small">Total Klaim</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="premium-card text-center position-relative overflow-hidden" style="border-left: 4px solid #4CAF50;">
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <i class="bi bi-check-circle" style="font-size: 48px; color: #4CAF50;"></i>
                </div>
                <h3 class="fw-bold mb-1" style="font-size: 36px; color: #4CAF50;">{{ $claimedItems }}</h3>
                <p class="text-muted mb-0 fw-medium small">Berhasil Diklaim</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- CHART: Monthly Trend -->
        <div class="col-lg-8">
            <div class="premium-card">
                <h5 class="fw-bold mb-4"><i class="bi bi-graph-up me-2 text-danger"></i>Tren Laporan 6 Bulan Terakhir</h5>
                <div style="position: relative; height: 140px; width: 100%;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- TOP CATEGORIES -->
        <div class="col-lg-4">
            <div class="premium-card">
                <h5 class="fw-bold mb-4"><i class="bi bi-tags me-2 text-danger"></i>Kategori Teratas</h5>
                @forelse($topFoundCategories as $cat)
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#fce8e8;">
                                <i class="bi bi-tag-fill text-danger small"></i>
                            </div>
                            <span class="fw-medium">{{ $cat->kategori }}</span>
                        </div>
                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">{{ $cat->total }} item</span>
                    </div>
                @empty
                    <p class="text-muted text-center py-3">Belum ada data kategori</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- RECENT ITEMS -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Barang Ditemukan Terbaru</h5>
                    <a href="{{ route('found-items.index') }}" class="btn btn-sm btn-outline-custom">Lihat Semua</a>
                </div>
                @forelse($recentFound as $item)
                    <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="bg-light rounded" style="width:45px;height:45px;overflow:hidden;flex-shrink:0;">
                            @if($item->image)
                                <img src="{{ (str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image)) }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="h-100 d-flex align-items-center justify-content-center"><i class="bi bi-image text-muted"></i></div>
                            @endif
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-bold text-dark text-truncate">{{ $item->nama_barang }}</div>
                            <small class="text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $item->lokasi_penemuan ?? '-' }}</small>
                        </div>
                        <small class="text-muted text-nowrap">{{ $item->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <p class="text-muted text-center py-3">Belum ada data</p>
                @endforelse
            </div>
        </div>

        <div class="col-lg-6">
            <div class="premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Barang Hilang Terbaru</h5>
                    <a href="{{ route('lost-items.index') }}" class="btn btn-sm btn-outline-custom">Lihat Semua</a>
                </div>
                @forelse($recentLost as $item)
                    <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="bg-light rounded" style="width:45px;height:45px;overflow:hidden;flex-shrink:0;">
                            @if($item->image)
                                <img src="{{ (str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image)) }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="h-100 d-flex align-items-center justify-content-center"><i class="bi bi-image text-muted"></i></div>
                            @endif
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-bold text-dark text-truncate">{{ $item->nama_barang }}</div>
                            <small class="text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $item->lokasi_terakhir ?? '-' }}</small>
                        </div>
                        <small class="text-muted text-nowrap">{{ $item->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <p class="text-muted text-center py-3">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('trendChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($months->pluck('label')) !!},
                datasets: [
                    {
                        label: 'Barang Ditemukan',
                        data: {!! json_encode($months->pluck('found')) !!},
                        backgroundColor: 'rgba(33, 150, 243, 0.8)',
                        borderRadius: 6,
                        barPercentage: 0.6,
                    },
                    {
                        label: 'Barang Hilang',
                        data: {!! json_encode($months->pluck('lost')) !!},
                        backgroundColor: 'rgba(227, 24, 55, 0.8)',
                        borderRadius: 6,
                        barPercentage: 0.6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true, pointStyle: 'circle' } }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
@endsection
