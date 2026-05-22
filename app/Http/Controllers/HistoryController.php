<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Claim;

class HistoryController extends Controller
{
    public function index()
    {
        $query = Claim::with(['foundItem', 'lostItem']);

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $claims = $query->latest()->get();

        return view('riwayat.index', compact('claims'));
    }
}