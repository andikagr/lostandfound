<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use Illuminate\Http\Request;

class FormFoundItemController extends Controller
{
    public function create()
    {
        return view('formfound_items.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tanggal_ditemukan' => 'required|date',
            'waktu_ditemukan' => 'required',
            'lokasi_penemuan' => 'required|string|max:255',
            'kronologi' => 'nullable|string',
            'nama_penemu' => 'required|string|max:255',
            'kontak_penemu' => 'required|numeric',
            'alamat_penemu' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('found-items', 'public');
        }

        $data['kontak'] = $data['kontak_penemu'];
        $data['lokasi'] = $data['lokasi_penemuan'];
        FoundItem::create($data);

        return redirect()->route('found-items.index')
            ->with('success', 'Barang ditemukan berhasil disimpan');
    }
}
