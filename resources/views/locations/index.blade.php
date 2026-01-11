@extends('layouts.app')

@section('content')
<h3>Lokasi</h3>
<a href="{{ route('locations.create') }}" class="btn btn-primary mb-3">Tambah Lokasi</a>

<ul class="list-group">
@foreach($locations as $location)
<li class="list-group-item d-flex justify-content-between">
    {{ $location->nama_lokasi }}
    <div>
        <a href="{{ route('locations.show', $location->id) }}" class="btn btn-info btn-sm">Detail</a>
        <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-warning btn-sm">Edit</a>
    </div>
</li>
@endforeach
</ul>
@endsection
