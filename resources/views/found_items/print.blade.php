<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Barang Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 14px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container mt-4">
        <h3 class="text-center mb-4">Laporan Barang Ditemukan</h3>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Penemu</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td style="text-align:center;">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" width="80" style="object-fit:cover;">
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->tanggal_ditemukan ? $item->tanggal_ditemukan->format('d/m/Y') : '-' }}</td>
                        <td>{{ $item->lokasi_penemuan }}</td>
                        <td>{{ $item->nama_penemu }}</td>
                        <td>{{ $item->deskripsi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <small class="text-muted">Dicetak pada: {{ date('d-m-Y H:i') }}</small>
    </div>
</body>
</html>