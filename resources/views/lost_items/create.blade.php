@extends('layouts.app')

@section('content')
<div class="container-fluid p-4" style="background:#f5f5f5; min-height:100vh;">

    <h4 class="mb-4">
        {{ isset($item) ? 'Ubah Barang Hilang' : 'Tambah Barang Hilang' }}
    </h4>

    <div class="bg-white p-4 rounded shadow-sm">

        <form method="POST"
              action="{{ isset($item) ? route('lost-items.update', $item) : route('lost-items.store') }}"
              enctype="multipart/form-data">
            @csrf
            @isset($item)
                @method('PUT')
            @endisset

            <div class="row">

                {{-- IMAGE --}}
                <div class="col-md-4">
                    <div class="border bg-light mb-2" style="height:250px;">
                        <img id="imagePreview"
                             src="{{ isset($item) && $item->image? asset('storage/'.$item->image): 'https://via.placeholder.com/400x250?text=Preview' }}"
                             class="w-100 h-100"
                             style="object-fit:cover;">
                    </div>
                    <input type="file"
                           name="image"
                           id="imageInput"
                           class="form-control mb-2"
                           accept="image/*">

                    <button type="button"
                            class="btn btn-outline-secondary w-100"
                            onclick="resetImage()"> Hapus Gambar
                    </button>
                </div>

                {{-- FORM INPUT --}}
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Barang</label>
                            <input type="text"
                                   name="nama_barang"
                                   class="form-control"
                                   value="{{ old('nama_barang', $item->nama_barang ?? '') }}"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Kehilangan</label>
                            <input type="date"
                                   name="tanggal_hilang"
                                   class="form-control"
                                   value="{{ old('tanggal_hilang', optional($item->tanggal_hilang ?? null)->format('Y-m-d')) }}"
                                   required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <input type="text"
                                   name="kategori"
                                   class="form-control"
                                   value="{{ old('kategori', $item->kategori ?? '') }}"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kontak</label>
                            <input type="text"
                                   name="kontak"
                                   class="form-control"
                                   value="{{ old('kontak', $item->kontak ?? '') }}"
                                   required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lokasi Terakhir</label>
                        <input type="text"
                               name="lokasi_terakhir"
                               class="form-control"
                               value="{{ old('lokasi_terakhir', $item->lokasi_terakhir ?? '') }}"
                               required>
                    </div>
                </div>
            </div>

            {{-- DESKRIPSI --}}
            <div class="mt-4">
                <label class="form-label">Deskripsi Barang</label>
                <textarea name="deskripsi"
                          class="form-control"
                          rows="4"
                          required>{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
            </div>

            {{-- BUTTON --}}
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn {{ isset($item) ? 'btn-warning' : 'btn-success' }}">
                    {{ isset($item) ? 'Ubah' : 'Simpan' }}
                </button>

                <a href="{{ route('lost-items.index') }}" class="btn btn-secondary">Batal</a>
            </div>
            <input type="hidden" name="status_id" value="{{ $item->status_id ?? 1 }}">
        </form>

        {{-- DELETE --}}
        @isset($item)
        <form action="{{ route('lost-items.destroy', $item) }}"
              method="POST"
              class="mt-3"
              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Hapus</button>
        </form>
        @endisset

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageInput?.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => imagePreview.src = e.target.result;
            reader.readAsDataURL(file);
        }
    });
});

function resetImage() {
    document.getElementById('imageInput').value = '';
    document.getElementById('imagePreview').src =
        'https://via.placeholder.com/400x250?text=Preview';
}
</script>
@endsection