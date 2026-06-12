<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use App\Models\LostItem;
use App\Models\Claim;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Auto-cleanup legacy/broken image URLs silently
        \App\Models\FoundItem::where('image', 'not like', '%supabase.co%')
            ->whereNotNull('image')
            ->update(['image' => null]);
        \App\Models\LostItem::where('image', 'not like', '%supabase.co%')
            ->whereNotNull('image')
            ->update(['image' => null]);

        // Basic stats
        $totalFound = FoundItem::count();
        $totalLost = LostItem::count();
        $totalClaims = Claim::count();
        $claimedItems = Claim::where('status', 'diklaim')->count();

        // Monthly trend (last 6 months)
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabel = $date->translatedFormat('M Y');
            
            $foundCount = FoundItem::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            $lostCount = LostItem::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            
            $months->push([
                'label' => $monthLabel,
                'found' => $foundCount,
                'lost' => $lostCount,
            ]);
        }

        // Recent items (5 latest)
        $recentFound = FoundItem::latest()->take(5)->get();
        $recentLost = LostItem::latest()->take(5)->get();

        // Top categories
        $topFoundCategories = FoundItem::select('kategori', DB::raw('count(*) as total'))
            ->whereNotNull('kategori')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalFound', 'totalLost', 'totalClaims', 'claimedItems',
            'months', 'recentFound', 'recentLost', 'topFoundCategories'
        ));
    }
}
