<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\ArchiveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $archives = Archive::where('user_id', Auth::id())->latest()->paginate(10);
        return view('archive.index', compact('archives'));
    }

    public function create()
    {
        return view('archive.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'creator' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'contributor' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
            'type' => ['nullable', 'string', 'max:255'],
            'format' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:255'],
            'relation' => ['nullable', 'string', 'max:255'],
            'reach' => ['nullable', 'string', 'max:255'],
            'rights' => ['nullable', 'string', 'max:255'],
            'documents' => ['required', 'array', 'min:1'],
            'documents.*' => ['required', 'mimes:pdf', 'max:102400'],
        ]);

        $archive = Archive::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $document) {
                $path = $document->store('archives/documents', 'public');
                $archive->files()->create([
                    'archive_path' => $path,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('archive.index')->with('success', 'Arsip berhasil diupload');
    }

    public function show(Archive $archive)
    {
        $this->authorize('view', $archive);
        return view('archive.show', compact('archive'));
    }

    public function edit(Archive $archive)
    {
        $this->authorize('update', $archive);
        return view('archive.edit', compact('archive'));
    }

    public function update(Request $request, Archive $archive)
    {
        $this->authorize('update', $archive);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'creator' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'contributor' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
            'type' => ['nullable', 'string', 'max:255'],
            'format' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:255'],
            'relation' => ['nullable', 'string', 'max:255'],
            'reach' => ['nullable', 'string', 'max:255'],
            'rights' => ['nullable', 'string', 'max:255'],
            'documents' => ['nullable', 'array'],
            'documents.*' => ['nullable', 'mimes:pdf', 'max:102400'],
        ]);

        $archive->update($validated);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $document) {
                $path = $document->store('archives/documents', 'public');
                $archive->files()->create([
                    'archive_path' => $path,
                    'order' => $archive->files()->count() + $index,
                ]);
            }
        }

        return redirect()->route('archive.show', $archive)->with('success', 'Arsip berhasil diperbarui');
    }

    public function destroy(Archive $archive)
    {
        $this->authorize('delete', $archive);

        foreach ($archive->files as $file) {
            Storage::disk('public')->delete($file->archive_path);
        }

        $archive->delete();

        return redirect()->route('archive.index')->with('success', 'Arsip berhasil dihapus');
    }

    public function deleteFile(ArchiveFile $archiveFile)
    {
        $archive = $archiveFile->archive;

        $this->authorize('update', $archive);

        Storage::disk('public')->delete($archiveFile->archive_path);
        $archiveFile->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'File berhasil dihapus']);
        }

        return back()->with('success', 'File berhasil dihapus');
    }
}
