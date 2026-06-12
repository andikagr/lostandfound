<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Claim;

class HistoryController extends Controller
{
    public function index()
    {
        // Auto-cleanup legacy/broken image URLs silently
        \App\Models\Claim::where('bukti', 'not like', '%supabase.co%')
            ->where('bukti', '!=', '')
            ->update(['bukti' => '']);

        $query = Claim::with(['foundItem', 'lostItem']);

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $claims = $query->latest()->get();

        return view('riwayat.index', compact('claims'));
    }
}