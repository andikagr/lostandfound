<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\LostItem;
use App\Models\Notification;
use App\Models\User;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    protected SupabaseStorageService $storage;

    public function __construct(SupabaseStorageService $storage)
    {
        $this->storage = $storage;
    }

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
            'found_item_id'  => 'nullable|exists:found_items,id|required_without:lost_item_id',
            'lost_item_id'   => 'nullable|exists:lost_items,id|required_without:found_item_id',
            'nama_pemilik'   => 'required|string|max:255',
            'kontak_pemilik' => 'required|string|max:255',
            'lokasi_terakhir'=> 'required|string|max:255',
            'bukti'          => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data['user_id'] = Auth::id();
        $data['status']  = 'diklaim';

        if ($request->hasFile('bukti')) {
            $url = $this->storage->upload($request->file('bukti'), 'claim-bukti');
            if ($url) {
                $data['bukti'] = $url;
            }
        }

        $claim = Claim::create($data);

        // Send notifications
        $itemName    = '';
        $itemOwnerId = null;

        if (isset($data['found_item_id'])) {
            $foundItem   = FoundItem::find($data['found_item_id']);
            $itemName    = $foundItem->nama_barang ?? 'Barang';
            $itemOwnerId = $foundItem->user_id;
        } elseif (isset($data['lost_item_id'])) {
            $lostItem    = LostItem::find($data['lost_item_id']);
            $itemName    = $lostItem->nama_barang ?? 'Barang';
            $itemOwnerId = $lostItem->user_id;
        }

        // Notify item owner (if different from claimer)
        if ($itemOwnerId && $itemOwnerId !== Auth::id()) {
            Notification::send(
                $itemOwnerId,
                'claim_new',
                'Klaim Baru!',
                Auth::user()->name . ' mengajukan klaim untuk "' . $itemName . '"',
                route('riwayat.index')
            );
        }

        // Notify all admins
        $admins = User::where('role', 'admin')->where('id', '!=', Auth::id())->get();
        foreach ($admins as $admin) {
            Notification::send(
                $admin->id,
                'claim_new',
                'Klaim Baru Masuk',
                Auth::user()->name . ' mengklaim "' . $itemName . '"',
                route('riwayat.index')
            );
        }

        return redirect()
            ->route('riwayat.index')
            ->with('success', 'Claim berhasil dikirim.');
    }

    public function edit(Claim $claim)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        $item = $claim->foundItem ?? $claim->lostItem;
        return view('riwayat.edit', compact('claim', 'item'));
    }

    public function update(Request $request, Claim $claim)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'nama_pemilik'   => 'required|string|max:255',
            'kontak_pemilik' => 'required|string|max:255',
            'lokasi_terakhir'=> 'required|string|max:255',
            'bukti'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($request->hasFile('bukti')) {
            if ($claim->bukti) {
                $this->storage->delete($claim->bukti);
            }
            $url = $this->storage->upload($request->file('bukti'), 'claim-bukti');
            if ($url) {
                $data['bukti'] = $url;
            }
        }

        $claim->update($data);

        return redirect()
            ->route('riwayat.index')
            ->with('success', 'Claim berhasil diperbarui.');
    }

    public function destroy(Claim $claim)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($claim->bukti) {
            $this->storage->delete($claim->bukti);
        }

        $claim->delete();

        return redirect()
            ->route('riwayat.index')
            ->with('success', 'Claim berhasil dihapus.');
    }
}