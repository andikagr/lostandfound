@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Edit Barang Hilang</h4>

        {{-- FORM UPDATE --}}
        <form method="POST" action="{{ route('lost-items.update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- IMAGE --}}
                <div class="col-md-4">
                    <div class="border mb-2" style="height:200px;">
                        <img src="{{ $item->image ? (str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image)) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                             class="w-100 h-100"
                             style="object-fit:cover">
                    </div>

                    <input type="file" name="image" class="form-control mb-2">

                    <button type="button" class="btn btn-secondary btn-sm"
                            onclick="document.querySelector('input[name=image]').value = ''">
                        Hapus Gambar
                    </button>
                </div>

                {{-- FORM DATA --}}
                <div class="col-md-8">
                    <input type="text"
                           name="nama_barang"
                           class="form-control mb-2"
                           placeholder="Nama Barang"
                           value="{{ old('nama_barang', $item->nama_barang) }}">

                    <input type="text"
                           name="kategori"
                           class="form-control mb-2"
                           placeholder="Kategori"
                           value="{{ old('kategori', $item->kategori) }}">

                    <input type="text"
                           name="lokasi_terakhir"
                           class="form-control mb-2"
                           placeholder="Lokasi Terakhir"
                           value="{{ old('lokasi_terakhir', $item->lokasi_terakhir) }}">

                    <input type="date"
                           name="tanggal_hilang"
                           class="form-control mb-2"
                           value="{{ old('tanggal_hilang', optional($item->tanggal_hilang)->format('Y-m-d')) }}">

                    <input type="text"
                           name="kontak"
                           class="form-control mb-2"
                           placeholder="Kontak"
                           value="{{ old('kontak', $item->kontak) }}">

                    <textarea name="deskripsi"
                              class="form-control mb-3"
                              rows="4"
                              placeholder="Deskripsi Barang">{{ old('deskripsi', $item->deskripsi) }}</textarea>

                    {{-- BUTTON --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">Ubah</button>
                        <a href="{{ route('lost-items.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </div>
        </form>

        {{-- FORM HAPUS --}}
        <form method="POST"
              action="{{ route('lost-items.destroy', $item->id) }}"
              onsubmit="return confirm('Yakin ingin menghapus data ini?')"
              class="mt-3">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Hapus</button>
        </form>

    </div>
</div>
@endsection