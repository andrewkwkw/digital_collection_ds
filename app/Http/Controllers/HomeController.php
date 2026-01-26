<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil query dari URL (aman walau kosong)
        $search = $request->query('search', '');
        $filter = $request->query('filter', '');

        // 2. Ambil semua tipe arsip unik (untuk dropdown)
        $types = Archive::query()
            ->whereNotNull('type')
            ->distinct()
            ->pluck('type');

        // 3. Query arsip + relasi file
        $archives = Archive::with('files')
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->when($filter, function ($q) use ($filter) {
                $q->where('type', $filter);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // 4. Group by tipe (untuk gallery per kategori)
        $archivesByType = $archives->groupBy('type');

        // 5. Kirim SEMUA ke view
        return view('welcome', compact(
            'search',
            'filter',
            'types',
            'archivesByType'
        ));
    }
}
