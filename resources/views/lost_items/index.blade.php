@extends('layouts.app')

@section('content')
<div class="container-fluid p-4" style="min-height:100vh;">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Barang Hilang</h4>
        <a href="{{ route('lost-items.create') }}" class="btn btn-primary">+ Tambah Laporan</a>
    </div>

    <div class="bg-white p-3 rounded shadow-sm">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-primary">
                <tr>
                    <th width="120">Gambar</th>
                    <th>Nama Barang</th>
                    <th>Lokasi Terakhir</th>
                    <th class="text-center" width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}"
                                     width="100"
                                     height="100"
                                     class="rounded"
                                     style="object-fit: cover;"
                                     alt="{{ $item->nama_barang }}"
                                     onerror="this.onerror=null;this.src='https://via.placeholder.com/100?text=Img+Error';">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->lokasi_terakhir }}</td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                @auth
                                    <a href="{{ route('claim-items.create-for-lost', $item->id) }}" class="btn btn-success btn-sm">Saya Menemukan</a>
                                @endauth

                                <a href="{{ route('lost-items.show', $item) }}" class="btn btn-info btn-sm">Detail</a>
                                
                                @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->id() === $item->user_id))
                                    <a href="{{ route('lost-items.edit', $item) }}" class="btn btn-warning btn-sm">Ubah</a>

                                    <form action="{{ route('lost-items.destroy', $item) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            Belum ada laporan barang hilang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(method_exists($items, 'links'))
            <div class="mt-3">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
@endsection