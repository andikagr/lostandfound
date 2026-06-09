<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LostItemController extends Controller
{
    public function index(Request $request)
    {
        $query = LostItem::query();

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
            $query->where('lokasi_terakhir', 'like', '%' . $request->lokasi . '%');
        }

        // Filter by date
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_hilang', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_hilang', '<=', $request->tanggal_sampai);
        }

        $items = $query->latest()->get();

        // Get unique categories and locations for filter dropdowns
        $categories = LostItem::whereNotNull('kategori')->distinct()->pluck('kategori');
        $locations = LostItem::whereNotNull('lokasi_terakhir')->distinct()->pluck('lokasi_terakhir');

        return view('lost_items.index', compact('items', 'categories', 'locations'));
    }

    public function create()
    {
        return view('lost_items.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_barang' => 'required|string',
            'tanggal_hilang' => 'required|date',
            'kategori' => 'required|string',
            'kontak' => 'required|string',
            'lokasi_terakhir' => 'required|string',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data['status_id'] = 1;
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
            $data['image'] = $base64;
        }

        LostItem::create($data);

        return redirect()
            ->route('lost-items.index')
            ->with('success', 'Laporan barang hilang berhasil disimpan');
    }

    public function show($id)
    {
        $item = LostItem::findOrFail($id);
        return view('lost_items.show', compact('item'));
    }

    public function edit($id)
    {
        $item = LostItem::findOrFail($id);

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak punya akses');
        }

        return view('lost_items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = LostItem::findOrFail($id);

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak punya akses');
        }

        $data = $request->validate([
            'nama_barang' => 'required|string',
            'kategori' => 'required|string',
            'lokasi_terakhir' => 'required|string',
            'tanggal_hilang' => 'required|date',
            'kontak' => 'required|string',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status_id' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
            $data['image'] = $base64;
        }

        $item->update($data);

        return redirect()
            ->route('lost-items.index')
            ->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $item = LostItem::findOrFail($id);

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak punya akses');
        }

        $item->delete();

        return redirect()
            ->route('lost-items.index')
            ->with('success', 'Data berhasil dihapus');
    }
}