<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class FoundItemController extends Controller
{
    public function index(Request $request)
    {
        $query = FoundItem::query();

        if (!(Auth::check() && Auth::user()->role === 'admin')) {
            $query->doesntHave('claims');
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by location
        if ($request->filled('lokasi')) {
            $query->where('lokasi_penemuan', 'like', '%' . $request->lokasi . '%');
        }

        // Filter by date
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_ditemukan', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_ditemukan', '<=', $request->tanggal_sampai);
        }

        $items = $query->latest()->get();

        // Get unique categories and locations for filter dropdowns
        $categories = FoundItem::whereNotNull('kategori')->distinct()->pluck('kategori');
        $locations = FoundItem::whereNotNull('lokasi_penemuan')->distinct()->pluck('lokasi_penemuan');

        return view('found_items.index', compact('items', 'categories', 'locations'));
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