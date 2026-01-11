<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class FoundItemController extends Controller
{
    public function index()
    {
        $items = FoundItem::doesntHave('claims')->latest()->get();
        return view('found_items.index', compact('items'));
    }

    public function print()
    {
        $items = FoundItem::all();
        return view('found_items.print', compact('items'));
    }

    public function show($id)
    {
        $item = FoundItem::findOrFail($id);
        return view('found_items.show', compact('item'));
    }

    public function edit($id)
    {
        Gate::authorize('admin-only');
        $item = FoundItem::findOrFail($id);

        return view('found_items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('admin-only');
        $item = FoundItem::findOrFail($id);

        $data = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_ditemukan' => 'nullable|date',
            'waktu_ditemukan' => 'nullable',
            'lokasi_penemuan' => 'nullable|string|max:255',
            'kronologi' => 'nullable|string',
            'nama_penemu' => 'nullable|string|max:255',
            'kontak_penemu' => 'nullable|string|max:255',
            'alamat_penemu' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $data['image'] = $request->file('image')->store('found-items', 'public');
        }

        $item->update($data);

        return redirect()->route('found-items.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Gate::authorize('admin-only');
        $item = FoundItem::findOrFail($id);

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('found-items.index')->with('success', 'Data berhasil dihapus');
    }
}