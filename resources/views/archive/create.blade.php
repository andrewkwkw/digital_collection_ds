<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-brand-500/10 rounded-lg">
                <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-black leading-tight text-gray-800 dark:text-white tracking-tight">
                {{ __('Upload Arsip Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-3xl border border-gray-100 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('archive.store') }}" enctype="multipart/form-data" id="archiveForm" class="space-y-8">
                        @csrf

                        <div class="bg-gray-50/50 dark:bg-gray-900/20 p-6 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                            <label for="documents" class="block text-sm font-black text-brand-700 dark:text-brand-400 uppercase tracking-widest mb-4">
                                {{ __('Dokumen PDF (Wajib)') }}
                            </label>
                            
                            <div class="relative group">
                                <input type="file" id="documents" name="documents[]" multiple accept="application/pdf" required
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                                    file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0
                                    file:text-xs file:font-black file:uppercase file:tracking-widest
                                    file:bg-brand-500 file:text-white
                                    hover:file:bg-brand-600 file:cursor-pointer transition-all" />
                                <p class="mt-3 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 font-medium">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Maksimal 100MB per file. Anda dapat memilih beberapa file sekaligus.
                                </p>
                            </div>

                            <div id="documentList" class="mt-6 grid grid-cols-1 gap-3"></div>

                            @if ($errors->has('documents') || $errors->has('documents.*'))
                                <ul class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1">
                                    @foreach ($errors->get('documents') as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                    @foreach ($errors->get('documents.*') as $fileErrors)
                                        @foreach ((array) $fileErrors as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="border-t border-gray-100 dark:border-gray-700 pt-8">
                            <div class="flex items-center gap-2 mb-8">
                                <span class="w-8 h-8 rounded-full bg-brand-500 text-white flex items-center justify-center text-xs font-bold">2</span>
                                <h3 class="text-xl font-black text-gray-800 dark:text-white tracking-tight">{{ __('Metadata Dokumen') }}</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="title" :value="__('Judul Dokumen')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="title" class="block mt-1 w-full bg-gray-50/50 dark:bg-gray-900/40 border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl" type="text" name="title" :value="old('title')" required placeholder="Masukkan judul utama arsip..." />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="creator" :value="__('Pembuat (Creator)')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="creator" class="block mt-1 w-full bg-gray-50/50 dark:bg-gray-900/40 border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl" type="text" name="creator" :value="old('creator')" placeholder="Nama individu atau instansi" />
                                    <x-input-error :messages="$errors->get('creator')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="date" :value="__('Tanggal Dokumen')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="date" class="block mt-1 w-full bg-gray-50/50 dark:bg-gray-900/40 border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl" type="date" name="date" :value="old('date')" />
                                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="subject" :value="__('Subjek / Kata Kunci')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <textarea id="subject" name="subject" rows="2" class="block mt-1 w-full bg-gray-50/50 dark:bg-gray-900/40 border-gray-200 dark:border-gray-700 dark:text-gray-100 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all" placeholder="Contoh: Kepegawaian, Laporan Tahunan, SK Rektor">{{ old('subject') }}</textarea>
                                    <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                                </div>

                                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4 p-6 bg-gray-50/30 dark:bg-gray-900/10 rounded-2xl border border-gray-100 dark:border-gray-700">
                                    <div>
                                        <x-input-label for="publisher" :value="__('Penerbit')" class="text-xs uppercase tracking-wider font-black text-gray-400" />
                                        <x-text-input id="publisher" class="block mt-1 w-full text-sm border-gray-200 dark:bg-gray-800 rounded-lg" type="text" name="publisher" :value="old('publisher')" />
                                    </div>
                                    <div>
                                        <x-input-label for="contributor" :value="__('Kontributor')" class="text-xs uppercase tracking-wider font-black text-gray-400" />
                                        <x-text-input id="contributor" class="block mt-1 w-full text-sm border-gray-200 dark:bg-gray-800 rounded-lg" type="text" name="contributor" :value="old('contributor')" />
                                    </div>
                                    <div>
                                        <x-input-label for="type" :value="__('Tipe')" class="text-xs uppercase tracking-wider font-black text-gray-400" />
                                        <x-text-input id="type" class="block mt-1 w-full text-sm border-gray-200 dark:bg-gray-800 rounded-lg" type="text" name="type" :value="old('type')" />
                                    </div>
                                    <div>
                                        <x-input-label for="format" :value="__('Format')" class="text-xs uppercase tracking-wider font-black text-gray-400" />
                                        <x-text-input id="format" class="block mt-1 w-full text-sm border-gray-200 dark:bg-gray-800 rounded-lg" type="text" name="format" :value="old('format')" placeholder="pdf" />
                                    </div>
                                    <div>
                                        <x-input-label for="source" :value="__('Sumber')" class="text-xs uppercase tracking-wider font-black text-gray-400" />
                                        <x-text-input id="source" class="block mt-1 w-full text-sm border-gray-200 dark:bg-gray-800 rounded-lg" type="text" name="source" :value="old('source')" />
                                    </div>
                                    <div>
                                        <x-input-label for="relation" :value="__('Relasi')" class="text-xs uppercase tracking-wider font-black text-gray-400" />
                                        <x-text-input id="relation" class="block mt-1 w-full text-sm border-gray-200 dark:bg-gray-800 rounded-lg" type="text" name="relation" :value="old('relation')" />
                                    </div>
                                    <div>
                                        <x-input-label for="reach" :value="__('Jangkauan')" class="text-xs uppercase tracking-wider font-black text-gray-400" />
                                        <x-text-input id="reach" class="block mt-1 w-full text-sm border-gray-200 dark:bg-gray-800 rounded-lg" type="text" name="reach" :value="old('reach')" />
                                    </div>
                                    <div>
                                        <x-input-label for="rights" :value="__('Hak Cipta')" class="text-xs uppercase tracking-wider font-black text-gray-400" />
                                        <x-text-input id="rights" class="block mt-1 w-full text-sm border-gray-200 dark:bg-gray-800 rounded-lg" type="text" name="rights" :value="old('rights')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-10 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('archive.index') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-brand-600 transition-colors">
                                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                {{ __('Batal & Kembali') }}
                            </a>
                            <x-primary-button class="bg-brand-500 hover:bg-brand-600 px-8 py-3 rounded-xl shadow-lg shadow-brand-500/20 transform transition active:scale-95">
                                <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                {{ __('Simpan & Upload') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('documents').addEventListener('change', function(e) {
            const docList = document.getElementById('documentList');
            docList.innerHTML = '';
            
            Array.from(this.files).forEach((file, index) => {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm animate-in fade-in slide-in-from-left-2 duration-300';
                div.style.animationDelay = `${index * 50}ms`;
                
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                div.innerHTML = `
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-red-50 dark:bg-red-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800 dark:text-white truncate max-w-[200px] md:max-w-md">${file.name}</p>
                            <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">${fileSize} MB</p>
                        </div>
                    </div>
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-brand-500 text-white text-[10px] font-bold shadow-sm shadow-brand-500/20">${index + 1}</span>
                `;
                docList.appendChild(div);
            });
        });
    </script>
</x-app-layout>