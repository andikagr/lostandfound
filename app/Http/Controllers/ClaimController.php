<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    public function create($foundItemId)
    {
        $foundItem = FoundItem::findOrFail($foundItemId);
        $myLostItems = LostItem::where('user_id', Auth::id())->latest()->get();
        return view('claim_items.create', compact('foundItem', 'myLostItems'));
    }

    public function createForLost($lostItemId)
    {
        $lostItem = LostItem::findOrFail($lostItemId);
        return view('claim_items.create', compact('lostItem'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'found_item_id' => 'nullable|exists:found_items,id|required_without:lost_item_id',
            'lost_item_id' => 'nullable|exists:lost_items,id|required_without:found_item_id',
            'nama_pemilik' => 'required|string|max:255',
            'kontak_pemilik' => 'required|numeric',
            'lokasi_terakhir' => 'required|string|max:255',
            'bukti' => 'required|file|max:2048',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'diklaim';

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('claim-bukti', 'public');
        }

        Claim::create($data);

        return redirect()
            ->route('riwayat.index')
            ->with('success', 'Claim berhasil dikirim.');
    }

    public function edit(Claim $claim)
    {
        // Pastikan hanya pemilik claim yang bisa edit
        if ($claim->user_id !== Auth::id()) {
            abort(403);
        }

        // Ambil data item terkait untuk ditampilkan (readonly)
        $item = $claim->foundItem ?? $claim->lostItem;

        return view('riwayat.edit', compact('claim', 'item'));
    }

    public function update(Request $request, Claim $claim)
    {
        if ($claim->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'kontak_pemilik' => 'required|numeric',
            'lokasi_terakhir' => 'required|string|max:255',
            'bukti' => 'nullable|file|max:2048', // bukti boleh null kalau tidak diupdate
        ]);

        if ($request->hasFile('bukti')) {
            // Hapus bukti lama jika ada
            if ($claim->bukti) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($claim->bukti);
            }
            $data['bukti'] = $request->file('bukti')->store('claim-bukti', 'public');
        }

        $claim->update($data);

        return redirect()
            ->route('riwayat.index')
            ->with('success', 'Claim berhasil diperbarui.');
    }

    public function destroy(Claim $claim)
    {
        if ($claim->user_id !== Auth::id()) {
            abort(403);
        }

        if ($claim->bukti) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($claim->bukti);
        }

        $claim->delete();

        return redirect()
            ->route('riwayat.index')
            ->with('success', 'Claim berhasil dihapus.');
    }
}