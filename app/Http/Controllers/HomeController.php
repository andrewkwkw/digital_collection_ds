<?php

namespace App\Http\Controllers;
use App\Models\HeroSlide;
use App\Models\Archive;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // HERO SLIDES (max 5)
        $heroSlides = HeroSlide::where('is_active', true)
            ->orderBy('order', 'asc') // Urutkan dari angka terkecil ke terbesar
            ->get();

        // SEARCH & FILTER
        $search = $request->query('search', '');
        $filter = $request->query('filter', '');

        // TIPE ARSIP
        $types = Archive::query()
            ->whereNotNull('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        // ARSIP + FILE
        $archives = Archive::with('files')
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->when($filter, function ($q) use ($filter) {
                $q->where('type', $filter);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // GROUP BY TYPE
        $archivesByType = $archives->groupBy('type')->take(8);

        // ⬇️ KIRIM SEMUANYA
        return view('welcome', compact(
            'heroSlides',
            'search',
            'filter',
            'types',
            'archivesByType'
        ));
    }
}