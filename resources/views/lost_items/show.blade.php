@extends('layouts.app')

@section('content')
<div class="container-fluid p-4" style="min-height:100vh;">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Detail Barang Hilang</h4>
        <a href="{{ route('lost-items.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}"
                             class="img-fluid rounded w-100"
                             style="object-fit: cover; max-height: 400px;"
                             alt="{{ $item->nama_barang }}">
                    @else
                        <img src="https://via.placeholder.com/400x300?text=No+Image"
                             class="img-fluid rounded w-100"
                             alt="No Image">
                    @endif
                </div>
                <div class="col-md-8">
                    <h3 class="mb-3">{{ $item->nama_barang }}</h3>
                    
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Kategori</th>
                            <td>: {{ $item->kategori }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi Terakhir</th>
                            <td>: {{ $item->lokasi_terakhir }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Hilang</th>
                            <td>: {{ $item->tanggal_hilang ? $item->tanggal_hilang->format('d M Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kontak</th>
                            <td>: {{ $item->kontak }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>: {{ $item->deskripsi }}</td>
                        </tr>
                    </table>

                    <div class="mt-4 d-flex gap-2">
                        @auth
                            <a href="{{ route('claim-items.create-for-lost', $item->id) }}" class="btn btn-success">Saya Menemukan</a>
                        @endauth
                        
                        @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->id() === $item->user_id))
                            <a href="{{ route('lost-items.edit', $item->id) }}" class="btn btn-warning">Ubah</a>
                            <form action="{{ route('lost-items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection