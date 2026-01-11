@extends('layouts.app')

@section('content')
    <div class="container-fluid p-4" style="background:#f5f5f5; min-height:100vh;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Daftar Barang Ditemukan</h4>

            <div class="d-flex gap-2">
                <a href="{{ route('found-items.print') }}" target="_blank" class="btn btn-outline-secondary">
                    <i class="bi bi-printer"></i> Export / Print</a>
                <a href="{{ route('form-found-items.create') }}" class="btn btn-success">+ Tambah Barang</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-3 rounded shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th width="80">Gambar</th>
                        <th>Nama Barang</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Penemu</th>
                        <th width="250">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        <img src="{{ $item->image
                        ? asset('storage/' . $item->image)
                        : 'https://via.placeholder.com/80' }}" width="70" height="70" style="object-fit:cover;">
                                    </td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>{{ $item->tanggal_ditemukan ? $item->tanggal_ditemukan->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $item->lokasi_penemuan }}</td>
                                    <td>{{ $item->nama_penemu }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('found-items.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                                            @can('admin-only')
                                                <a href="{{ route('found-items.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            @endcan
                                            <a href="{{ route('claim-items.create', $item->id) }}"
                                                class="btn btn-success btn-sm">Claim</a>

                                            @can('admin-only')
                                                <form action="{{ route('found-items.destroy', $item->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data barang ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection