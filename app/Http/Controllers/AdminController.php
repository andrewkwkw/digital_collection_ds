<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function index()
    {
        // Mengambil daftar user dengan role admin
        $admins = User::where('role', 'admin')->latest()->paginate(10);
        // Pastikan path view sesuai dengan struktur folder Anda, contoh: 'tambah admin.index'
        return view('admin.add_admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.add_admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.admin.index')->with('success', 'Akun Admin berhasil didaftarkan.');
    }

    // Method edit dan update TELAH DIHAPUS untuk privasi data personal admin

    public function destroy(User $admin)
    {
        // Proteksi agar tidak menghapus diri sendiri atau sesama superadmin
        if ($admin->role === 'superadmin') {
            return back()->with('error', 'Tidak bisa menghapus akun superadmin.');
        }

        $admin->delete();
        return redirect()->route('admin.admin.index')->with('success', 'Akses Admin telah dicabut (akun dihapus).');
    }
}