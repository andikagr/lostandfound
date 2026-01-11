<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use App\Models\Location;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemHistoryController extends Controller
{
    public function index()
    {
        $items = LostItem::with('location', 'category', 'status')->get();
        return view('lost_items.index', compact('items'));
    }

    public function riwayat(Request $request)
    {
        $query = LostItem::with('location', 'category', 'status');

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_hilang', [$request->start_date, $request->end_date]);
        }

        $items = $query->latest()->get();
        $statuses = Status::all();

        return view('lost_items.riwayat', compact('items', 'statuses'));
    }

    public function create()
    {
        $locations  = Location::all();
        $categories = Category::all();
        $statuses   = Status::all(); 

        return view('lost_items.create', compact('locations', 'categories', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'    => 'required|string',
            'category_id'    => 'required|exists:categories,id',
            'location_id'    => 'required|exists:locations,id',
            'status_id'      => 'required|exists:statuses,id',
            'tanggal_hilang' => 'required|date',
            'deskripsi'      => 'nullable|string',
            'kontak'         => 'required|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('lost_items', 'public');
        }

        LostItem::create($validated);

        return redirect()
            ->route('lost-items.index')
            ->with('success', 'Laporan barang hilang berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $item = LostItem::findOrFail($id);

        $validated = $request->validate([
            'nama_barang'    => 'required|string',
            'category_id'    => 'required|exists:categories,id',
            'location_id'    => 'required|exists:locations,id',
            'status_id'      => 'required|exists:statuses,id',
            'tanggal_hilang' => 'required|date',
            'deskripsi'      => 'nullable|string',
            'kontak'         => 'required|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $validated['image'] = $request->file('image')->store('lost_items', 'public');
        }

        $item->update($validated);

        return redirect()
            ->route('lost-items.index')
            ->with('success', 'Laporan barang hilang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = LostItem::findOrFail($id);

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()
            ->route('lost-items.index')
            ->with('success', 'Laporan barang hilang berhasil dihapus');
    }
}