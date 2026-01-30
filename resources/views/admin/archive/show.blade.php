<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-brand-500/10 rounded-lg">
                <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <h2 class="text-2xl font-black leading-tight text-gray-800 dark:text-white tracking-tight">
                {{ $archive->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($archive->files->count() > 0)
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-3xl border border-gray-100 dark:border-gray-700">
                    <div class="p-8">
                        <h3
                            class="text-sm font-black text-brand-700 dark:text-brand-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            {{ __('Lampiran File PDF') }}
                        </h3>

                        <div class="grid grid-cols-1 gap-3">
                            @foreach ($archive->files as $file)
                                <div
                                    class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-brand-500/50 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 flex items-center justify-center bg-red-100 dark:bg-red-900/20 rounded-xl">
                                            <span class="text-[10px] font-black text-red-600 dark:text-red-400">PDF</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-bold text-gray-800 dark:text-white truncate max-w-[200px] md:max-w-md">
                                                {{ $file->original_filename ?? basename($file->archive_path) }}
                                            </span>
                                            <span
                                                class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Document
                                                ID: #{{ $file->id }}</span>
                                        </div>
                                    </div>

                                    <div class="flex gap-2">
                                        <a href="{{ route('archive.show_file', ['id' => $file->id, 'from' => 'admin']) }}"
                                            class="inline-flex items-center justify-center p-2 text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-500/10 rounded-lg transition-colors"
                                            title="Lihat">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-3xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center gap-2 mb-8">
                        <span
                            class="w-8 h-8 rounded-full bg-brand-500 text-white flex items-center justify-center text-xs font-bold italic">i</span>
                        <h3 class="text-xl font-black text-gray-800 dark:text-white tracking-tight">
                            {{ __('Metadata Lengkap') }}
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                    {{ __('Judul Utama') }}
                                </h4>
                                <p class="text-gray-800 dark:text-gray-200 font-bold">{{ $archive->title }}</p>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                    {{ __('Pembuat / Creator') }}
                                </h4>
                                <p class="text-gray-800 dark:text-gray-200 font-bold">{{ $archive->creator ?? '-' }}</p>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                    {{ __('Tanggal Dokumen') }}
                                </h4>
                                <p class="text-gray-800 dark:text-gray-200 font-bold">
                                    {{ $archive->date ? \Carbon\Carbon::parse($archive->date)->format('d F Y') : '-' }}
                                </p>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                    {{ __('Subjek') }}
                                </h4>
                                <p class="text-gray-800 dark:text-gray-200 font-bold">{{ $archive->subject ?? '-' }}</p>
                            </div>
                        </div>

                        <div
                            class="bg-gray-50/50 dark:bg-gray-900/40 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 grid grid-cols-1 gap-4">
                            <div class="grid grid-cols-2 gap-4 text-xs font-medium">
                                <div>
                                    <span class="block text-gray-400 mb-1">Penerbit</span>
                                    <span
                                        class="text-gray-700 dark:text-gray-300">{{ $archive->publisher ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-gray-400 mb-1">Kontributor</span>
                                    <span
                                        class="text-gray-700 dark:text-gray-300">{{ $archive->contributor ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-gray-400 mb-1">Tipe</span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $archive->type ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-gray-400 mb-1">Format</span>
                                    <span
                                        class="text-gray-700 dark:text-gray-300 font-bold text-brand-500">{{ strtoupper($archive->format ?? 'pdf') }}</span>
                                </div>
                                <div>
                                    <span class="block text-gray-400 mb-1">Sumber</span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $archive->source ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-gray-400 mb-1">Relasi</span>
                                    <span
                                        class="text-gray-700 dark:text-gray-300">{{ $archive->relation ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-gray-400 mb-1">Jangkauan</span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $archive->reach ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-gray-400 mb-1">Hak Cipta</span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $archive->rights ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">
                            {{ __('Deskripsi Singkat') }}
                        </h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed italic">
                            {{ $archive->description ?? 'Tidak ada deskripsi untuk arsip ini.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between px-4">
                <a href="{{ route('admin.archive.index') }}"
                    class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-brand-600 transition-colors">
                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Kembali ke Daftar') }}
                </a>

                <div class="flex gap-3">
                    <a href="{{ route('admin.archive.edit', $archive) }}"
                        class="inline-flex items-center px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-yellow-500/20 transition-all active:scale-95">
                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        {{ __('Edit Arsip') }}
                    </a>

                    <form action="{{ route('admin.archive.destroy', $archive) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh arsip dan file di dalamnya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 bg-white dark:bg-gray-800 border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white text-sm font-bold rounded-xl transition-all active:scale-95">
                            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            {{ __('Hapus') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>