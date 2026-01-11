<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Claim;

class HistoryController extends Controller
{
    public function index()
    {
        $claims = Claim::with(['foundItem', 'lostItem'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('riwayat.index', compact('claims'));
    }
}