<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    // PUBLIC METHODS
    public function index()
    {
        $team = TeamMember::orderBy('order')->orderBy('created_at')->get();
        return view('public_guest.team', compact('team'));
    }

    public function show($id)
    {
        $member = TeamMember::findOrFail($id);
        return view('public_guest.team-profile', compact('member'));
    }

    // ADMIN METHODS
    public function manage()
    {
        $team = TeamMember::orderBy('order')->orderBy('created_at')->get();
        return view('admin.team.index', compact('team'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048', // 2MB Max
            'cv' => 'nullable|mimes:pdf|max:5120', // 5MB Max
            'education' => 'nullable|string',
            'nidn' => 'nullable|string',
            'nip' => 'nullable|string',
            'order' => 'integer'
        ]);

        $data = $request->except(['photo', 'cv']);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('team-photos', 'public');
        }

        if ($request->hasFile('cv')) {
            $data['cv_path'] = $request->file('cv')->store('team-cvs', 'public');
        }

        TeamMember::create($data);

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(TeamMember $teamMember)
    {
        return view('admin.team.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'cv' => 'nullable|mimes:pdf|max:5120',
            'order' => 'integer'
        ]);

        $data = $request->except(['photo', 'cv']);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($teamMember->photo_path) {
                Storage::disk('public')->delete($teamMember->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('team-photos', 'public');
        }

        if ($request->hasFile('cv')) {
            // Delete old cv
            if ($teamMember->cv_path) {
                Storage::disk('public')->delete($teamMember->cv_path);
            }
            $data['cv_path'] = $request->file('cv')->store('team-cvs', 'public');
        }

        $teamMember->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Data anggota tim berhasil diperbarui.');
    }

    public function destroy(TeamMember $teamMember)
    {
        if ($teamMember->photo_path) {
            Storage::disk('public')->delete($teamMember->photo_path);
        }
        if ($teamMember->cv_path) {
            Storage::disk('public')->delete($teamMember->cv_path);
        }

        $teamMember->delete();

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}
