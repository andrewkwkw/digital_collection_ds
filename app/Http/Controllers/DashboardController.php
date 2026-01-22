<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama.
     */
    public function index()
    {
        // 1. Total semua arsip
        $totalArchives = Archive::count();

        // 2. Total tipe/kategori arsip yang unik
        $totalTypes = Archive::distinct('type')->count('type');

        // 3. Jumlah arsip yang baru diupload bulan ini
        $newThisMonth = Archive::whereMonth('created_at', Carbon::now()->month)
                               ->whereYear('created_at', Carbon::now()->year)
                               ->count();

        // 4. Ambil 5 arsip terbaru beserta data user pengunggahnya (Eager Loading)
        $recentArchives = Archive::with('user')->latest()->take(5)->get();

        // 5. Distribusi jumlah arsip per tipe (untuk progress bar)
        $typeDistribution = Archive::selectRaw('type, count(*) as total')
                                   ->groupBy('type')
                                   ->pluck('total', 'type');

        return view('dashboard', compact(
            'totalArchives', 
            'totalTypes', 
            'newThisMonth', 
            'recentArchives', 
            'typeDistribution'
        ));
    }
}