@extends('layouts.app')

@section('content')
    <div class="container-fluid p-4" style="background:#f5f5f5; min-height:100vh;">

        <h4 class="mb-4">Claim Barang</h4>

        <div class="bg-white p-4 rounded shadow-sm">

            <form method="POST" action="{{ route('claim-items.store') }}" enctype="multipart/form-data">
                @csrf

                @if(isset($foundItem))
                    <input type="hidden" name="found_item_id" value="{{ $foundItem->id }}">
                @endif

                @if(isset($lostItem))
                    <input type="hidden" name="lost_item_id" value="{{ $lostItem->id }}">
                    <div class="alert alert-info mb-3">
                        Anda akan mengklaim penemuan untuk barang hilang: <strong>{{ $lostItem->nama_barang }}</strong>
                    </div>
                @endif

                <div class="row">
                    {{-- FORM INPUT --}}
                    <div class="col-md-8">

                        <div class="mb-3">
                            <label class="form-label">Nama Pemilik</label>
                            <input type="text" name="nama_pemilik" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kontak Pemilik</label>
                            <input type="text" name="kontak_pemilik" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi Terakhir Barang</label>
                            <input type="text" name="lokasi_terakhir" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bukti Pendukung</label>
                            <input type="file" name="bukti" id="imageInput" class="form-control">
                        </div>

                    </div>

                    {{-- PREVIEW --}}
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light text-center">
                            <img id="imagePreview" src="https://via.placeholder.com/400x250?text=Bukti"
                                class="img-fluid rounded mb-2" style="max-height: 250px; object-fit: cover;">
                            <p class="small text-muted mb-0">Preview Bukti Kepemilikan</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        Claim Barang
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
                'https://via.placeholder.com/400x250?text=Bukti';
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