<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LostItem;
use App\Models\FoundItem;
use App\Models\Claim;
use App\Http\Resources\LostItemResource;
use App\Http\Resources\FoundItemResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class LostFoundController extends Controller
{
    // ========================
    // LOST ITEMS
    // ========================

    public function storeLostItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'lokasi_terakhir' => 'required|string|max:255',
            'tanggal_hilang' => 'required|date',
            'deskripsi' => 'required|string',
            'kontak' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imagePath = $request->hasFile('image') 
            ? $request->file('image')->store('lost_items', 'public') 
            : null;

        $lostItem = LostItem::create([
            'user_id' => $request->user()->id,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'lokasi_terakhir' => $request->lokasi_terakhir,
            'status_id' => 1,
            'tanggal_hilang' => $request->tanggal_hilang,
            'deskripsi' => $request->deskripsi,
            'kontak' => $request->kontak,
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Laporan kehilangan berhasil dibuat',
            'data' => new LostItemResource($lostItem)
        ], 201);
    }

    public function indexLostItems()
    {
        $items = LostItem::doesntHave('claims')->with('status', 'user')->latest()->get();

        return response()->json([
            'message' => 'List data lost items',
            'data' => LostItemResource::collection($items)
        ], 200);
    }

    public function showLostItem($id)
    {
        $lostItem = LostItem::with('status', 'user')->find($id);

        if (!$lostItem) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail lost item',
            'data' => new LostItemResource($lostItem)
        ], 200);
    }

    public function updateLostItem(Request $request, $id)
    {
        $lostItem = LostItem::find($id);

        if (!$lostItem) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if ($request->user()->role !== 'admin') return response()->json(['message' => 'Unauthorized: Hanya admin yang dapat mengubah data'], 403);

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'sometimes|required|string|max:255',
            'kategori' => 'sometimes|required|string|max:255',
            'lokasi_terakhir' => 'sometimes|required|string|max:255',
            'tanggal_hilang' => 'sometimes|required|date',
            'deskripsi' => 'sometimes|required|string',
            'kontak' => 'sometimes|required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        if ($request->hasFile('image')) {
            if ($lostItem->image) Storage::disk('public')->delete($lostItem->image);
            $lostItem->image = $request->file('image')->store('lost_items', 'public');
        }

        $lostItem->update($request->except('image'));

        return response()->json([
            'message' => 'Lost item berhasil diperbarui',
            'data' => new LostItemResource($lostItem)
        ], 200);
    }

    public function deleteLostItem(Request $request, $id)
    {
        $lostItem = LostItem::find($id);

        if (!$lostItem) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if ($request->user()->role !== 'admin') return response()->json(['message' => 'Unauthorized: Hanya admin yang dapat menghapus data'], 403);

        if ($lostItem->image) Storage::disk('public')->delete($lostItem->image);
        $lostItem->delete();

        return response()->json(['message' => 'Lost item berhasil dihapus'], 200);
    }

    // ========================
    // FOUND ITEMS
    // ========================

    public function storeFoundItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_ditemukan' => 'required|date',
            'waktu_ditemukan' => 'required',
            'lokasi_penemuan' => 'required|string|max:255',
            'nama_penemu' => 'required|string|max:255',
            'kontak_penemu' => 'required|string|max:255',
            'alamat_penemu' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $imagePath = $request->hasFile('image') 
            ? $request->file('image')->store('found_items', 'public') 
            : null;

        $foundItem = FoundItem::create(array_merge(
            $request->except('image'),
            ['image' => $imagePath, 'user_id' => $request->user()->id]
        ));

        return response()->json([
            'message' => 'Laporan penemuan barang berhasil dibuat',
            'data' => new FoundItemResource($foundItem)
        ], 201);
    }

    public function indexFoundItems()
    {
        $items = FoundItem::doesntHave('claims')->latest()->get();

        return response()->json([
            'message' => 'List Data Found Items',
            'data' => FoundItemResource::collection($items)
        ], 200);
    }

    public function updateFoundItem(Request $request, $id)
    {
        $foundItem = FoundItem::find($id);

        if (!$foundItem) return response()->json(['message' => 'Found Item tidak ditemukan'], 404);
        if ($foundItem->user_id !== $request->user()->id) return response()->json(['message' => 'Forbidden'], 403);

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_ditemukan' => 'required|date',
            'waktu_ditemukan' => 'required',
            'lokasi_penemuan' => 'required|string|max:255',
            'nama_penemu' => 'required|string|max:255',
            'kontak_penemu' => 'required|string|max:255',
            'alamat_penemu' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $data = $request->except(['image', 'user_id']);

        if ($request->hasFile('image')) {
            if ($foundItem->image) Storage::disk('public')->delete($foundItem->image);
            $data['image'] = $request->file('image')->store('found_items', 'public');
        }

        $foundItem->update($data);

        return response()->json([
            'message' => 'Found Item berhasil diperbarui',
            'data' => new FoundItemResource($foundItem)
        ], 200);
    }

    public function deleteFoundItem(Request $request, $id)
    {
        $foundItem = FoundItem::find($id);

        if (!$foundItem) return response()->json(['message' => 'Found Item tidak ditemukan'], 404);
        if ($foundItem->user_id !== $request->user()->id) return response()->json(['message' => 'Forbidden'], 403);

        if ($foundItem->image) Storage::disk('public')->delete($foundItem->image);
        $foundItem->delete();

        return response()->json(['message' => 'Found Item berhasil dihapus'], 200);
    }

    // ========================
    // CLAIMS
    // ========================

    public function claimItem(Request $request, $found_item_id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pemilik' => 'required|string',
            'kontak_pemilik' => 'required|string',
            'lokasi_terakhir' => 'required|string',
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $buktiPath = $request->file('bukti')->store('claims_evidence', 'public');

        $claim = Claim::create([
            'found_item_id' => $found_item_id,
            'user_id' => $request->user()->id,
            'nama_pemilik' => $request->nama_pemilik,
            'kontak_pemilik' => $request->kontak_pemilik,
            'lokasi_terakhir' => $request->lokasi_terakhir,
            'bukti' => $buktiPath,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Klaim berhasil dikirim',
            'data' => $claim
        ], 201);
    }

    public function updateClaim(Request $request, $id)
    {
        $claim = Claim::find($id);

        if (!$claim) return response()->json(['message' => 'Claim tidak ditemukan'], 404);
        if ($request->user()->role !== 'admin') return response()->json(['message' => 'Forbidden: Hanya admin yang dapat mengubah riwayat'], 403);

        $validator = Validator::make($request->all(), [
            'nama_pemilik' => 'required|string',
            'kontak_pemilik' => 'required|string',
            'lokasi_terakhir' => 'required|string',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $data = $request->only(['nama_pemilik', 'kontak_pemilik', 'lokasi_terakhir']);

        if ($request->hasFile('bukti')) {
            if ($claim->bukti) Storage::disk('public')->delete($claim->bukti);
            $data['bukti'] = $request->file('bukti')->store('claims_evidence', 'public');
        }

        $claim->update($data);

        return response()->json([
            'message' => 'Claim berhasil diperbarui',
            'data' => $claim
        ], 200);
    }

    public function deleteClaim(Request $request, $id)
    {
        $claim = Claim::find($id);

        if (!$claim) return response()->json(['message' => 'Claim tidak ditemukan'], 404);
        if ($request->user()->role !== 'admin') return response()->json(['message' => 'Forbidden: Hanya admin yang dapat menghapus riwayat'], 403);

        if ($claim->bukti) Storage::disk('public')->delete($claim->bukti);
        $claim->delete();

        return response()->json(['message' => 'Claim berhasil dihapus'], 200);
    }

    // ========================
    // HISTORY
    // ========================

    public function history(Request $request)
    {
        $user = $request->user();

        $lostItemsQuery = LostItem::latest();
        $claimsQuery = Claim::with(['foundItem', 'lostItem'])->latest();

        if ($user->role !== 'admin') {
            $lostItemsQuery->where('user_id', $user->id);
            $claimsQuery->where('user_id', $user->id);
        }

        return response()->json([
            'message' => 'Riwayat Aktivitas',
            'data' => [
                'laporan_kehilangan' => LostItemResource::collection($lostItemsQuery->get()),
                'riwayat_klaim' => $claimsQuery->get()
            ]
        ], 200);
    }
}
