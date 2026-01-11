@extends('layouts.app')

@section('content')
<div class="container-fluid p-4" style="background:#f5f5f5; min-height:100vh;">

    <h4 class="mb-4">
        Tambah Barang Ditemukan
    </h4>

    <div class="bg-white p-4 rounded shadow-sm">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('form-found-items.store') }}"
              enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <div class="border bg-light mb-2" style="height:250px;">
                        <img id="imagePreview"
                             src="https://via.placeholder.com/400x250?text=Preview"
                             class="w-100 h-100"
                             style="object-fit:cover;">
                    </div>

                    <input type="file" name="image" id="imageInput" class="form-control mb-2">

                    <button type="button"
                            class="btn btn-outline-danger btn-sm w-100"
                            onclick="resetImage()">
                        Hapus Gambar
                    </button>
                </div>

                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control"
                                   value="{{ old('nama_barang') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control"
                                   value="{{ old('kategori') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Ditemukan</label>
                            <input type="date" name="tanggal_ditemukan" class="form-control"
                                   value="{{ old('tanggal_ditemukan') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Waktu Ditemukan</label>
                            <input type="time" name="waktu_ditemukan" class="form-control"
                                   value="{{ old('waktu_ditemukan') }}" required>
                        </div>
                    </div>
                        <div class="col-md-6">
                            <label class="form-label">Lokasi Penemuan</label>
                            <input type="text" name="lokasi_penemuan" class="form-control"
                                   value="{{ old('lokasi_penemuan') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kronologi Penemuan</label>
                        <textarea name="kronologi" class="form-control" rows="3">{{ old('kronologi') }}</textarea>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Nama Penemu</label>
                        <input type="text" name="nama_penemu" class="form-control"
                               value="{{ old('nama_penemu') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kontak Penemu</label>
                        <input type="text" name="kontak_penemu" class="form-control"
                               value="{{ old('kontak_penemu') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Alamat Penemu</label>
                        <input type="text" name="alamat_penemu" class="form-control"
                               value="{{ old('alamat_penemu') }}" required>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="form-label">Deskripsi Barang</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                </div>
            </div>


            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    Simpan
                </button>

                <a href="{{ route('found-items.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
<script>
function resetImage() {
    document.getElementById('imageInput').value = '';
    document.getElementById('imagePreview').src =
        'https://via.placeholder.com/400x250?text=Preview';
}

document.getElementById('imageInput').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('imagePreview').src = e.target.result;
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
