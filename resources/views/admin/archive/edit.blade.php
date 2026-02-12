<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div
                    class="p-3 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-white">
                        {{ __('Edit Arsip') }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Perbarui data atau kelola file dokumen.
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <form method="POST" action="{{ route('admin.archive.update', $archive) }}" enctype="multipart/form-data"
                class="space-y-8">
                @csrf
                @method('PATCH')

                {{-- CARD 1: FILE MANAGEMENT (POSISI ATAS) --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-100 text-brand-600 dark:bg-brand-900 dark:text-brand-300 text-sm font-bold ring-4 ring-white dark:ring-gray-800">1</span>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Kelola File Dokumen</h3>
                    </div>

                    {{-- SECTION: FILE YANG SUDAH ADA --}}
                    @if ($archive->files->count() > 0)
                        <div class="mb-8">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">File Tersimpan</h4>
                            <div class="grid grid-cols-1 gap-3">
                                @foreach ($archive->files as $file)
                                    <div
                                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700 group">
                                        <div class="flex items-center gap-4 min-w-0">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 rounded-lg shadow-sm text-red-500">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <a href="{{ asset('storage/' . $file->archive_path) }}" target="_blank"
                                                    class="block text-sm font-bold text-gray-800 dark:text-gray-200 truncate hover:text-brand-600 hover:underline">
                                                    {{ $file->original_filename ?? basename($file->archive_path) }}
                                                </a>
                                                <span class="text-[10px] text-gray-500 uppercase tracking-wide">Terupload</span>
                                            </div>
                                        </div>

                                        <button type="button" onclick="deleteFile('{{ $file->id }}')"
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                            title="Hapus File">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- SECTION: UPLOAD BARU --}}
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Upload File Baru
                            (Opsional)</h4>
                        <div class="relative group">
                            <label for="documents"
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl cursor-pointer bg-gray-50 dark:bg-gray-800/50 hover:bg-brand-50 dark:hover:bg-brand-900/10 hover:border-brand-400 transition-all duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                        <span class="text-brand-600 font-bold hover:underline">Klik cari file</span>
                                        atau drag disini
                                    </p>
                                    <p class="text-[10px] text-gray-400 mt-1">PDF Only</p>
                                </div>
                                <input type="file" id="documents" name="documents[]" multiple accept="application/pdf"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                            </label>
                        </div>

                        {{-- New Files Preview --}}
                        <div id="documentList" class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3"></div>

                        <x-input-error :messages="$errors->get('documents')" class="mt-2" />
                        <x-input-error :messages="$errors->get('documents.*')" class="mt-2" />
                    </div>
                </div>

                {{-- CARD 2: METADATA FORM (POSISI BAWAH) --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div
                        class="p-6 sm:p-8 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-100 text-brand-600 dark:bg-brand-900 dark:text-brand-300 text-sm font-bold ring-4 ring-white dark:ring-gray-800">2</span>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Metadata & Informasi</h3>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 space-y-6">
                        {{-- Nomor & Judul --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-1">
                                <x-input-label for="number" :value="__('Nomor Dokumen')" class="mb-1" />
                                <x-text-input id="number" class="block w-full" type="text" name="number"
                                    :value="old('number', $archive->number)" placeholder="Contoh: 001/SK/2024" />
                                <x-input-error :messages="$errors->get('number')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="title" :value="__('Judul Dokumen')" class="mb-1" />
                                <x-text-input id="title" class="block w-full" type="text" name="title"
                                    :value="old('title', $archive->title)" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Grid: Creator & Date --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="creator" :value="__('Pembuat (Creator)')" class="mb-1" />
                                <x-text-input id="creator" class="block w-full" type="text" name="creator"
                                    :value="old('creator', $archive->creator)" />
                                <x-input-error :messages="$errors->get('creator')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="date" :value="__('Tanggal Dokumen')" class="mb-1" />
                                <x-text-input id="date" class="block w-full" type="text" name="date" :value="old('date', $archive->date)" placeholder="Contoh: 1 Januari 2024 atau 2024-01-01" />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Subject --}}
                        <div>
                            <x-input-label for="subject" :value="__('Subjek / Kata Kunci')" class="mb-1" />
                            <textarea id="subject" name="subject" rows="2"
                                class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm transition-colors">{{ old('subject', $archive->subject) }}</textarea>
                            <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                        </div>

                        {{-- Description --}}
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi Abstrak')" class="mb-1" />
                            <textarea id="description" name="description" rows="4"
                                class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm transition-colors">{{ old('description', $archive->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Section Separator --}}
                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-100 dark:border-gray-700"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span
                                    class="px-3 bg-white dark:bg-gray-800 text-xs font-bold uppercase tracking-widest text-gray-400">
                                    Metadata Teknis
                                </span>
                            </div>
                        </div>

                        {{-- Technical Metadata Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <x-input-label for="publisher" :value="__('Penerbit')"
                                    class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="publisher" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="publisher" :value="old('publisher', $archive->publisher)" />
                            </div>
                            <div>
                                <x-input-label for="contributor" :value="__('Kontributor')"
                                    class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="contributor"
                                    class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50" type="text"
                                    name="contributor" :value="old('contributor', $archive->contributor)" />
                            </div>
                            <div>
                                <x-input-label for="type" :value="__('Tipe')" class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="type" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="type" :value="old('type', $archive->type)" />
                            </div>
                            <div>
                                <x-input-label for="format" :value="__('Format')" class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="format" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="format" :value="old('format', $archive->format)" />
                            </div>
                            <div>
                                <x-input-label for="source" :value="__('Sumber')" class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="source" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="source" :value="old('source', $archive->source)" />
                            </div>
                            <div>
                                <x-input-label for="relation" :value="__('Relasi')"
                                    class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="relation" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="relation" :value="old('relation', $archive->relation)" />
                            </div>
                            <div>
                                <x-input-label for="reach" :value="__('Jangkauan')"
                                    class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="reach" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="reach" :value="old('reach', $archive->reach)" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="rights" :value="__('Hak Cipta')"
                                    class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="rights" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="rights" :value="old('rights', $archive->rights)" />
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div
                        class="px-6 sm:px-8 py-6 bg-gray-50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <a href="{{ route('admin.archive.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white transition-colors">
                            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-brand-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-brand-500 focus:bg-brand-500 active:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // Hapus File yang sudah ada
        function deleteFile(fileId) {
            if (!confirm('Hapus file ini secara permanen dari server?')) return;

            fetch(`/archive-file/${fileId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Refresh halaman setelah hapus sukses
                    } else {
                        alert('Gagal menghapus file.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan koneksi.');
                });
        }

        // Preview File Baru yang akan diupload
        document.getElementById('documents').addEventListener('change', function (e) {
            const docList = document.getElementById('documentList');
            docList.innerHTML = '';

            if (this.files.length > 0) {
                Array.from(this.files).forEach((file, index) => {
                    const div = document.createElement('div');
                    div.className = 'flex items-center gap-3 p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm animate-in fade-in slide-in-from-top-2 duration-300';
                    div.style.animationDelay = `${index * 50}ms`;

                    const fileSize = (file.size / 1024 / 1024).toFixed(2);

                    div.innerHTML = `
                        <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-brand-50 dark:bg-brand-900/20 rounded-lg text-brand-600">
                            <span class="text-[10px] font-black">NEW</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-800 dark:text-gray-200 truncate">${file.name}</p>
                            <p class="text-[10px] text-gray-500">${fileSize} MB</p>
                        </div>
                    `;
                    docList.appendChild(div);
                });
            }
        });
    </script>
</x-app-layout>