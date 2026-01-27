<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroSlide;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $heroes = HeroSlide::orderBy('order')->get();
        return view('superadmin.hero', compact('heroes'));
    }

    public function store(Request $request)
    {
        $totalHero = HeroSlide::count();

        if ($totalHero >= 5) {
            return back()->with('error', 'Maksimal hanya 5 hero yang bisa diupload.');
        }

        $request->validate([
            'title' => 'required',
            'image' => 'required|image',
        ]);

        HeroSlide::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->file('image')->store('hero', 'public'),
            'is_active' => false,
            'order' => HeroSlide::max('order') + 1,
        ]);

        return back()->with('success', 'Hero berhasil ditambahkan.');
    }


    public function toggle($id)
    {
        $hero = HeroSlide::findOrFail($id);

        if (!$hero->is_active) {
            $activeCount = HeroSlide::where('is_active', true)->count();

            if ($activeCount >= 5) {
                return back()->with('error', 'Maksimal 5 hero aktif.');
            }
        }

        $hero->update([
            'is_active' => !$hero->is_active
        ]);

        return back();
    }


    public function reorder(Request $request)
{
    // Validasi bahwa data yang dikirim adalah array
    $request->validate([
        'orders' => 'required|array',
    ]);

    // Loop data array yang dikirim dari form
    // Format: orders[ID_HERO] = URUTAN_BARU
    foreach ($request->orders as $id => $order) {
        // Cari hero berdasarkan ID key, lalu update kolom order
        HeroSlide::where('id', $id)->update([
            'order' => $order
        ]);
    }

    return back()->with('success', 'Urutan semua hero berhasil diperbarui.');
}



    public function destroy($id)
    {
        $slide = HeroSlide::findOrFail($id);

        if ($slide->image_path) {
            Storage::disk('public')->delete($slide->image_path);
        }

        $slide->delete();

        return back()->with('success', 'Hero slide dihapus');
    }
}
