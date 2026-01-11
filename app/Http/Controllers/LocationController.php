<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();
        return view('locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255'
        ]);

        Location::create([
            'nama_lokasi' => $request->nama_lokasi
        ]);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Lokasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $location = Location::find($id);

        if (!$location) {
            return redirect()
                ->route('locations.index')
                ->with('error', 'Data lokasi tidak ditemukan');
        }

        return view('locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $location = Location::find($id);

        if (!$location) {
            return redirect()
                ->route('locations.index')
                ->with('error', 'Data lokasi tidak ditemukan');
        }

        return view('locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $location = Location::find($id);

        if (!$location) {
            return redirect()
                ->route('locations.index')
                ->with('error', 'Data lokasi tidak ditemukan');
        }

        $request->validate([
            'nama_lokasi' => 'required|string|max:255'
        ]);

        $location->update([
            'nama_lokasi' => $request->nama_lokasi
        ]);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Lokasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = Location::find($id);

        if (!$location) {
            return redirect()
                ->route('locations.index')
                ->with('error', 'Data lokasi tidak ditemukan');
        }

        $location->delete();

        return redirect()
            ->route('locations.index')
            ->with('success', 'Lokasi berhasil dihapus');
    }
}
