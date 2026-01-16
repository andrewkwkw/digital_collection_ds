<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!$request->user() || !$request->user()->isSuperAdmin()) {
                abort(403, 'Hanya superadmin yang bisa mengelola admin.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $admins = User::where('role', 'admin')->paginate(10);
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);
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

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan');
    }

    public function edit(User $admin)
    {
        $this->authorize('update', $admin);
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $this->authorize('update', $admin);
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $admin->id],
        ]);

        $admin->update($validated);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diperbarui');
    }

    public function destroy(User $admin)
    {
        $this->authorize('delete', $admin);
        
        if ($admin->isSuperAdmin()) {
            return back()->with('error', 'Tidak bisa menghapus superadmin');
        }

        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus');
    }
}
