<x-app-layout>
    <x-slot name="header">
        {{-- HEADER: Bersih, hanya Judul dan ID --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between w-full gap-6">
            <div class="flex items-center gap-4">
                <div
                    class="p-3 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3">
                        <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight truncate">
                            {{ __('Detail Arsip') }}
                        </h2>
                        <span
                            class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 dark:bg-gray-700 text-gray-500 border border-gray-200 dark:border-gray-600">
                            ID: #{{ $archive->id }}
                        </span>
                    </div>
                    <p
                        class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5 truncate max-w-xs md:max-w-md">
                        {{ $archive->title }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ showDeleteModal: false }">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ACTION TOOLBAR: Posisi di sini (Diatas Card File) --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-2">

                {{-- Kiri: Tombol Kembali --}}
                <a href="{{ route('admin.archive.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
                    <div
                        class="w-8 h-8 rounded-full bg-white dark:bg-brand-900 border border-brand-200 dark:border-brand-800 flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                    {{ __('Kembali') }}
                </a>

                {{-- Kanan: Edit & Hapus --}}
                <div class="flex items-center gap-3 w-full md:w-auto">
                    {{-- Edit --}}
                    <a href="{{ route('admin.archive.edit', $archive) }}"
                        class="inline-flex items-center justify-center w-full md:w-auto px-4 py-2 bg-amber-500 hover:bg-amber-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-sm transition ease-in-out duration-150">
                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit
                    </a>

                    {{-- Hapus --}}
                    <button type="button" @click="showDeleteModal = true"
                        class="inline-flex items-center justify-center w-full md:w-auto px-4 py-2 bg-red-600 hover:bg-red-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-sm transition ease-in-out duration-150">
                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Hapus
                    </button>
                </div>
            </div>

            {{-- SECTION 1: LAMPIRAN FILE --}}
            @if ($archive->files->count() > 0)
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div
                        class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                </path>
                            </svg>
                            {{ __('File Lampiran') }}
                        </h3>
                        <span
                            class="text-xs font-medium text-gray-500 bg-white dark:bg-gray-700 px-2 py-1 rounded-md border border-gray-200 dark:border-gray-600">
                            {{ $archive->files->count() }} File
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($archive->files as $file)
                                <div
                                    class="group flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-brand-500 dark:hover:border-brand-500 hover:shadow-md hover:shadow-brand-500/5 transition-all duration-300">
                                    <div class="flex items-center gap-4 overflow-hidden">
                                        <div
                                            class="flex-shrink-0 w-12 h-12 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center border border-red-100 dark:border-red-800/30">
                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p
                                                class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate group-hover:text-brand-600 transition-colors">
                                                {{ $file->original_filename ?? basename($file->archive_path) }}
                                            </p>
                                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mt-0.5">
                                                Document ID: #{{ $file->id }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex-shrink-0 ms-4">
                                        <a href="{{ route('archive.show_file', ['id' => $file->id, 'from' => 'admin']) }}"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-bold rounded-lg group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                                            <span>Buka</span>
                                            <svg class="w-3 h-3 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
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

            {{-- SECTION 2: INFORMASI & METADATA --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Informasi Dokumen') }}
                    </h3>
                </div>

                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

                        {{-- Kolom Kiri: Info Utama --}}
                        <div class="space-y-6">
                            <div>
                                <label
                                    class="text-[10px] uppercase tracking-widest font-bold text-gray-400 dark:text-gray-500 mb-1 block">Judul
                                    Dokumen</label>
                                <p class="text-lg font-bold text-gray-800 dark:text-white leading-snug">
                                    {{ $archive->title }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="text-[10px] uppercase tracking-widest font-bold text-gray-400 dark:text-gray-500 mb-1 block">Nomor
                                        Dokumen</label>
                                    <p class="font-medium text-gray-700 dark:text-gray-300">
                                        {{ $archive->number ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="text-[10px] uppercase tracking-widest font-bold text-gray-400 dark:text-gray-500 mb-1 block">Tahun</label>
                                    <p class="font-medium text-gray-700 dark:text-gray-300">
                                        {{ $archive->date ?? '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div>
                                    <label
                                        class="text-[10px] uppercase tracking-widest font-bold text-gray-400 dark:text-gray-500 mb-1 block">Pencipta</label>
                                    <p class="font-medium text-gray-700 dark:text-gray-300">
                                        {{ $archive->creator ?? '-' }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="text-[10px] uppercase tracking-widest font-bold text-gray-400 dark:text-gray-500 mb-1 block">Deskripsi</label>
                                <div
                                    class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700/50 italic">
                                    {{ $archive->description ?? 'Tidak ada deskripsi tersedia.' }}
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Metadata Detail --}}
                        <div>
                            <div
                                class="bg-gray-50 dark:bg-gray-700/20 rounded-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700/50">
                                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wide">Metadata Teknis
                                    </h4>
                                </div>
                                <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                                    @php
                                        $metaRows = [
                                            ['label' => 'Subjek', 'value' => $archive->subject],
                                            ['label' => 'Penerbit', 'value' => $archive->publisher],
                                            ['label' => 'Kontributor', 'value' => $archive->contributor],
                                            ['label' => 'Tipe Media', 'value' => $archive->type],
                                            ['label' => 'Format', 'value' => strtoupper($archive->format ?? 'PDF')],
                                            ['label' => 'Sumber', 'value' => $archive->source],
                                            ['label' => 'Hak Cipta', 'value' => $archive->rights],
                                        ];
                                    @endphp

                                    @foreach($metaRows as $row)
                                        <div
                                            class="grid grid-cols-3 gap-4 px-4 py-3 text-sm hover:bg-white dark:hover:bg-gray-700/30 transition-colors">
                                            <div class="font-medium text-gray-500 dark:text-gray-400">{{ $row['label'] }}
                                            </div>
                                            <div
                                                class="col-span-2 font-semibold text-gray-800 dark:text-gray-200 break-words">
                                                {{ $row['value'] ?? '-' }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- DELETE CONFIRMATION MODAL --}}
            <div x-cloak x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" role="dialog"
                aria-modal="true">

                {{-- Backdrop --}}
                <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-900/50 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
                    aria-hidden="true" @click="showDeleteModal = false">
                </div>

                <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100 dark:border-gray-700">

                        <div class="bg-white dark:bg-gray-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-lg font-bold leading-6 text-gray-900 dark:text-white"
                                        id="modal-title">Hapus Arsip</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            PERINGATAN: Menghapus arsip ini akan menghapus seluruh file lampiran di
                                            dalamnya secara permanen. Tindakan ini tidak dapat dibatalkan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/30 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <form action="{{ route('admin.archive.destroy', $archive) }}" method="POST"
                                class="inline-flex w-full sm:ml-3 sm:w-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-xl bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto transition-colors">
                                    Ya, Hapus Permanen
                                </button>
                            </form>
                            <button type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-xl bg-white dark:bg-gray-800 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto transition-colors"
                                @click="showDeleteModal = false">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>