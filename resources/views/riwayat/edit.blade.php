@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background:#f5f5f5; min-height:100vh;">
        <div class="bg-white p-4 rounded-3 shadow-sm border">
            <h3 class="fw-bold mb-4">Edit Claim Barang</h3>

            <form method="POST" action="{{ route('claim-items.update', $claim->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        {{-- INFO BARANG (READ ONLY) --}}
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="fw-bold text-dark">Informasi Barang</h5>
                            <p class="mb-1"><strong>Nama Barang:</strong> {{ $item->nama_barang }}</p>
                            <p class="mb-0"><strong>Lokasi Ditemukan/Hilang:</strong>
                                {{ $item->lokasi ?? $item->lokasi_terakhir ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Pemilik</label>
                            <input type="text" name="nama_pemilik" class="form-control"
                                value="{{ old('nama_pemilik', $claim->nama_pemilik) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kontak Pemilik</label>
                            <input type="text" name="kontak_pemilik" class="form-control"
                                value="{{ old('kontak_pemilik', $claim->kontak_pemilik) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi Terakhir Barang</label>
                            <input type="text" name="lokasi_terakhir" class="form-control"
                                value="{{ old('lokasi_terakhir', $claim->lokasi_terakhir) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bukti Pendukung (Biarkan kosong jika tidak ingin mengubah)</label>
                            <input type="file" name="bukti" id="imageInput" class="form-control">
                        </div>
                    </div>

                    {{-- PREVIEW --}}
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light text-center">
                            @php
                                $buktiUrl = $claim->bukti
                                    ? asset('storage/' . $claim->bukti)
                                    : 'https://via.placeholder.com/400x250?text=Bukti';
                            @endphp
                            <img id="imagePreview" src="{{ $buktiUrl }}" class="img-fluid rounded mb-2"
                                style="max-height: 250px; object-fit: cover;">
                            <p class="small text-muted mb-0">Preview Bukti Kepemilikan</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Update Claim
                    </button>

                    <a href="{{ route('riwayat.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script>
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