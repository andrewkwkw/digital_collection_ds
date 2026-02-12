<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div
                    class="p-3 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-white">
                        {{ __('Upload Arsip Baru') }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Lengkapi form di bawah secara berurutan.
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <form method="POST" action="{{ route('admin.archive.store') }}" enctype="multipart/form-data"
                id="archiveForm" class="space-y-8">
                @csrf

                {{-- CARD 1: UPLOAD AREA (POSISI ATAS) --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-100 text-brand-600 dark:bg-brand-900 dark:text-brand-300 text-sm font-bold ring-4 ring-white dark:ring-gray-800">1</span>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">File Dokumen</h3>
                    </div>

                    <div class="relative group">
                        <label for="documents"
                            class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl cursor-pointer bg-gray-50 dark:bg-gray-800/50 hover:bg-brand-50 dark:hover:bg-brand-900/10 hover:border-brand-400 dark:hover:border-brand-500 transition-all duration-300">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                <div
                                    class="w-12 h-12 mb-3 rounded-full bg-white dark:bg-gray-700 shadow-sm flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                </div>
                                <p class="mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="text-brand-600 font-bold hover:underline">Klik untuk pilih file</span>
                                    atau drag & drop disini
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Format PDF (Maksimal 100MB per file)
                                </p>
                            </div>
                            <input type="file" id="documents" name="documents[]" multiple accept="application/pdf"
                                required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </label>
                    </div>

                    {{-- Preview List --}}
                    <div id="documentList" class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3"></div>

                    {{-- Error Messages --}}
                    @if ($errors->has('documents') || $errors->has('documents.*'))
                        <div
                            class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-100 dark:border-red-800">
                            <ul class="text-xs text-red-600 dark:text-red-400 list-disc list-inside">
                                @foreach ($errors->get('documents') as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                                @foreach ($errors->get('documents.*') as $fileErrors)
                                    @foreach ((array) $fileErrors as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                    @endif
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

                        {{-- Judul --}}
                        <div>
                            <x-input-label for="title" :value="__('Judul Dokumen')" class="mb-1" />
                            <x-text-input id="title" class="block w-full" type="text" name="title" :value="old('title')"
                                required placeholder="Masukkan judul lengkap dokumen..." />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- Grid: Creator & Date --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="creator" :value="__('Pembuat (Creator)')" class="mb-1" />
                                <x-text-input id="creator" class="block w-full" type="text" name="creator"
                                    :value="old('creator')" placeholder="Nama orang atau instansi" />
                                <x-input-error :messages="$errors->get('creator')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="date" :value="__('Tanggal Dokumen')" class="mb-1" />
                                <x-text-input id="date" class="block w-full" type="date" name="date"
                                    :value="old('date')" />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Subject --}}
                        <div>
                            <x-input-label for="subject" :value="__('Subjek / Kata Kunci')" class="mb-1" />
                            <textarea id="subject" name="subject" rows="2"
                                class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm transition-colors"
                                placeholder="Contoh: Laporan Keuangan, Surat Keputusan, 2024">{{ old('subject') }}</textarea>
                            <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                        </div>

                        {{-- Description --}}
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi Abstrak')" class="mb-1" />
                            <textarea id="description" name="description" rows="4"
                                class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm transition-colors"
                                placeholder="Ringkasan isi dokumen...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Section Separator --}}
                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-100 dark:border-gray-700"></div>
                            </div>
                        </div>

                        {{-- Technical Metadata Grid (3 Kolom) --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <x-input-label for="publisher" :value="__('Penerbit')"
                                    class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="publisher" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="publisher" :value="old('publisher')" />
                            </div>
                            <div>
                                <x-input-label for="contributor" :value="__('Kontributor')"
                                    class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="contributor"
                                    class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50" type="text"
                                    name="contributor" :value="old('contributor')" />
                            </div>
                            <div>
                                <x-input-label for="type" :value="__('Tipe')" class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="type" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="type" :value="old('type')" />
                            </div>
                            <div>
                                <x-input-label for="format" :value="__('Format')" class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="format" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="format" :value="old('format')" placeholder="PDF" />
                            </div>
                            <div>
                                <x-input-label for="source" :value="__('Sumber')" class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="source" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="source" :value="old('source')" />
                            </div>
                            <div>
                                <x-input-label for="relation" :value="__('Relasi')"
                                    class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="relation" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="relation" :value="old('relation')" />
                            </div>
                            <div>
                                <x-input-label for="reach" :value="__('Jangkauan')"
                                    class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="reach" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="reach" :value="old('reach')" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="rights" :value="__('Hak Cipta')"
                                    class="text-xs mb-1 text-gray-500" />
                                <x-text-input id="rights" class="block w-full text-sm bg-gray-50 dark:bg-gray-900/50"
                                    type="text" name="rights" :value="old('rights')" />
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
                            Simpan Arsip
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <script>
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
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-100 dark:border-red-800/30">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate">${file.name}</p>
                            <p class="text-[10px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">${fileSize} MB</p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                        </div>
                    `;
                    docList.appendChild(div);
                });
            }
        });
    </script>
</x-app-layout>