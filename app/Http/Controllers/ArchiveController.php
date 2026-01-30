<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\ArchiveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArchiveController extends Controller
{

    public function jelajah(Request $request)
    {
        $search = $request->query('search'); // title
        $filter = $request->query('filter'); // type

        $types = Archive::select('type')
            ->whereNotNull('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        $query = Archive::with('files')->latest();

        // SEARCH BY TITLE
        if (!empty($search)) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        // FILTER BY TYPE
        if (!empty($filter)) {
            $query->where('type', $filter);
        }

        $archives = $query->paginate(12)->withQueryString();

        return view('public_guest.jelajah', compact(
            'archives',
            'types',
            'search',
            'filter'
        ));
    }


    public function index()
    {
        // Mengambil semua arsip dari semua user
        $archives = Archive::latest()->paginate(10);

        return view('admin.archive.index', compact('archives'));
    }

    public function create()
    {
        return view('admin.archive.create');
    }

    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Archive Store Started', ['all' => $request->all(), 'files' => $request->files->all()]);
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
            'documents.*' => ['required', 'mimes:pdf', 'max:51200'],
        ]);

        $archive = Archive::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $document) {
                $originalName = $document->getClientOriginalName();
                $path = $document->store('archives/documents', 'public');
                $archive->files()->create([
                    'archive_path' => $path,
                    'original_filename' => $originalName,
                    'order' => $index,
                ]);
            }
        }

        \Illuminate\Support\Facades\Log::info('Redirecting to Index');
        return redirect()->route('admin.archive.index')->with('success', 'Arsip berhasil diupload');
    }

    public function show(Archive $archive)
    {
        $this->authorize('view', $archive);
        return view('admin.archive.show', compact('archive'));
    }

    /**
     * Show archive detail for guest/public users
     */
    public function showGuest($id)
    {
        $archive = Archive::with('files')->findOrFail($id);

        return view('public_guest.show-guest', compact('archive'));
    }


    public function edit(Archive $archive)
    {
        $this->authorize('update', $archive);
        return view('admin.archive.edit', compact('archive'));
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
            'documents.*' => ['nullable', 'mimes:pdf', 'max:51200'],
        ]);

        $archive->update($validated);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $document) {
                $originalName = $document->getClientOriginalName();
                $path = $document->store('archives/documents', 'public');
                $archive->files()->create([
                    'archive_path' => $path,
                    'original_filename' => $originalName,
                    'order' => $archive->files()->count() + $index,
                ]);
            }
        }

        return redirect()->route('admin.archive.show', $archive)->with('success', 'Arsip berhasil diperbarui');
    }

    public function destroy(Archive $archive)
    {
        $this->authorize('delete', $archive);

        foreach ($archive->files as $file) {
            Storage::disk('public')->delete($file->archive_path);
        }

        $archive->delete();

        return redirect()->route('admin.archive.index')->with('success', 'Arsip berhasil dihapus');
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

    public function showFile($id)
    {
        $file = ArchiveFile::with('archive')->findOrFail($id);

        return view('public_guest.viewer-public', compact('file'));
    }

    public function downloadWatermarked($id, \App\Services\WatermarkService $watermarkService)
    {
        $file = ArchiveFile::findOrFail($id);
        $filePath = storage_path('app/public/' . $file->archive_path);

        return $watermarkService->generate($filePath, $file->original_filename);
    }
}
