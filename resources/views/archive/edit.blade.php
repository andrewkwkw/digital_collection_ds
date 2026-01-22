<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-brand-500/10 rounded-lg">
                <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-black leading-tight text-gray-800 dark:text-white tracking-tight">
                {{ __('Edit Arsip') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-3xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <form method="POST" action="{{ route('archive.update', $archive) }}" enctype="multipart/form-data" class="space-y-10">
                        @csrf
                        @method('PATCH')

                        @if ($archive->files->count() > 0)
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">{{ __('Koleksi PDF Saat Ini') }}</h3>
                                <div class="h-px flex-1 bg-gray-100 dark:bg-gray-700"></div>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-3">
                                @foreach ($archive->files as $file)
                                <div class="flex items-center justify-between p-4 bg-gray-50/50 dark:bg-gray-900/40 rounded-2xl border border-gray-100 dark:border-gray-700 group hover:border-brand-200 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"></path></svg>
                                        </div>
                                        <div class="flex flex-col">
                                            <a href="{{ asset('storage/' . $file->archive_path) }}" target="_blank"
                                               class="text-sm font-bold text-gray-700 dark:text-gray-200 hover:text-brand-600 transition-colors line-clamp-1">
                                                {{ $file->original_filename ?? basename($file->archive_path) }}
                                            </a>
                                            <span class="text-[10px] text-gray-400 font-medium uppercase tracking-tighter">Klik untuk meninjau file</span>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all" 
                                            onclick="deleteFile('{{ $file->id }}')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="bg-brand-50/30 dark:bg-brand-500/5 p-6 rounded-2xl border border-dashed border-brand-200 dark:border-brand-500/20">
                            <label for="documents" class="block text-sm font-black text-brand-700 dark:text-brand-400 uppercase tracking-widest mb-4">
                                {{ __('Tambah PDF Baru (Opsional)') }}
                            </label>
                            
                            <input type="file" id="documents" name="documents[]" multiple accept="application/pdf"
                                class="block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0
                                file:text-xs file:font-black file:uppercase file:tracking-widest
                                file:bg-white file:text-brand-600 file:shadow-sm
                                hover:file:bg-brand-50 file:cursor-pointer transition-all" />

                            <div id="documentList" class="mt-4 grid grid-cols-1 gap-2"></div>
                            
                            <x-input-error :messages="$errors->get('documents')" class="mt-2" />
                            <x-input-error :messages="$errors->get('documents.*')" class="mt-2" />
                        </div>

                        <div class="pt-4">
                            <div class="flex items-center gap-2 mb-8">
                                <h3 class="text-xl font-black text-gray-800 dark:text-white tracking-tight">{{ __('Pembaruan Metadata') }}</h3>
                                <div class="h-px flex-1 bg-gray-100 dark:bg-gray-700"></div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="title" :value="__('Judul Arsip')" class="font-bold" />
                                    <x-text-input id="title" class="block mt-1 w-full bg-gray-50/50 dark:bg-gray-900/40 border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl" type="text" name="title" :value="old('title', $archive->title)" required />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="creator" :value="__('Pembuat (Creator)')" class="font-bold" />
                                    <x-text-input id="creator" class="block mt-1 w-full bg-gray-50/50 dark:bg-gray-900/40 border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl" type="text" name="creator" :value="old('creator', $archive->creator)" />
                                    <x-input-error :messages="$errors->get('creator')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="date" :value="__('Tanggal Arsip')" class="font-bold" />
                                    <x-text-input id="date" class="block mt-1 w-full bg-gray-50/50 dark:bg-gray-900/40 border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl" type="date" name="date" :value="old('date', $archive->date?->format('Y-m-d'))" />
                                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="subject" :value="__('Subjek')" class="font-bold" />
                                    <textarea id="subject" name="subject" rows="2" class="block mt-1 w-full bg-gray-50/50 dark:bg-gray-900/40 border-gray-200 dark:border-gray-700 dark:text-gray-100 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all">{{ old('subject', $archive->subject) }}</textarea>
                                    <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="description" :value="__('Deskripsi')" class="font-bold" />
                                    <textarea id="description" name="description" rows="3" class="block mt-1 w-full bg-gray-50/50 dark:bg-gray-900/40 border-gray-200 dark:border-gray-700 dark:text-gray-100 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all">{{ old('description', $archive->description) }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                <div class="md:col-span-2 grid grid-cols-2 lg:grid-cols-3 gap-4 mt-4 p-5 bg-gray-50/30 dark:bg-gray-900/10 rounded-2xl border border-gray-100 dark:border-gray-700">
                                    @php
                                        $fields = [
                                            'publisher' => 'Penerbit',
                                            'type' => 'Tipe',
                                            'format' => 'Format',
                                            'source' => 'Sumber',
                                            'relation' => 'Relasi',
                                            'rights' => 'Hak Cipta',
                                            'contributor' => 'Kontributor',
                                            'reach' => 'Jangkauan'
                                        ];
                                    @endphp
                                    @foreach($fields as $id => $label)
                                    <div>
                                        <x-input-label for="{{ $id }}" :value="__($label)" class="text-[10px] uppercase font-black text-gray-400" />
                                        <x-text-input id="{{ $id }}" class="block mt-1 w-full text-sm border-gray-100 dark:bg-gray-800 rounded-lg" type="text" name="{{ $id }}" :value="old($id, $archive->$id)" />
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-12 pt-8 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('archive.show', $archive) }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button class="bg-brand-500 hover:bg-brand-600 px-10 py-3.5 rounded-2xl shadow-xl shadow-brand-500/20 transform transition active:scale-95">
                                {{ __('Perbarui & Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteFile(fileId) {
            if (!confirm('Hapus PDF ini dari sistem secara permanen?')) return;

            fetch(`/archive-file/${fileId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Gagal menghapus file');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi');
            });
        }

        document.getElementById('documents').addEventListener('change', function(e) {
            const docList = document.getElementById('documentList');
            docList.innerHTML = '';

            Array.from(this.files).forEach((file, index) => {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-xl border border-brand-100 dark:border-brand-500/20 shadow-sm animate-in fade-in slide-in-from-top-2 duration-300';
                
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                div.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="px-2 py-1 bg-brand-500 text-white text-[8px] font-black rounded uppercase tracking-tighter">NEW</div>
                        <div>
                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300 truncate max-w-[200px]">${file.name}</p>
                            <p class="text-[9px] text-gray-400 font-medium">${fileSize} MB</p>
                        </div>
                    </div>
                    <span class="text-brand-500 text-xs font-bold">#${index + 1}</span>
                `;
                docList.appendChild(div);
            });
        });
    </script>
</x-app-layout>