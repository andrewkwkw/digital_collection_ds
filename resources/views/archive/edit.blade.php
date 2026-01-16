<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit Arsip') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('archive.update', $archive) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Current Images -->
                        @if ($archive->images->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-4">{{ __('Gambar Saat Ini') }}</h3>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                    @foreach ($archive->images as $image)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Archive image" class="w-full h-24 object-cover rounded border border-gray-300 dark:border-gray-600">
                                            <form action="{{ route('archive.deleteImage', $image) }}" method="POST" class="absolute top-0 right-0 m-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded text-xs hover:bg-red-700" onclick="return confirm('Hapus gambar?')">✕</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Add More Images -->
                        <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                            <label for="images" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Tambah Gambar (Opsional)') }}
                            </label>
                            <div class="mt-2">
                                <input type="file" id="images" name="images[]" multiple accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                                    file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                                    file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900
                                    file:text-blue-700 dark:file:text-blue-200 hover:file:bg-blue-100 dark:hover:file:bg-blue-800" />
                            </div>
                            <div id="imagePreview" class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4"></div>
                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                            <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                        </div>

                        <!-- Metadata -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">{{ __('Metadata') }}</h3>

                            <!-- Title -->
                            <div class="mb-4">
                                <x-input-label for="title" :value="__('Judul')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $archive->title)" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Creator -->
                            <div class="mb-4">
                                <x-input-label for="creator" :value="__('Pembuat')" />
                                <x-text-input id="creator" class="block mt-1 w-full" type="text" name="creator" :value="old('creator', $archive->creator)" />
                                <x-input-error :messages="$errors->get('creator')" class="mt-2" />
                            </div>

                            <!-- Subject -->
                            <div class="mb-4">
                                <x-input-label for="subject" :value="__('Subjek')" />
                                <textarea id="subject" name="subject" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('subject', $archive->subject) }}</textarea>
                                <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <x-input-label for="description" :value="__('Deskripsi')" />
                                <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $archive->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Publisher -->
                                <div>
                                    <x-input-label for="publisher" :value="__('Penerbit')" />
                                    <x-text-input id="publisher" class="block mt-1 w-full" type="text" name="publisher" :value="old('publisher', $archive->publisher)" />
                                    <x-input-error :messages="$errors->get('publisher')" class="mt-2" />
                                </div>

                                <!-- Contributor -->
                                <div>
                                    <x-input-label for="contributor" :value="__('Kontributor')" />
                                    <x-text-input id="contributor" class="block mt-1 w-full" type="text" name="contributor" :value="old('contributor', $archive->contributor)" />
                                    <x-input-error :messages="$errors->get('contributor')" class="mt-2" />
                                </div>

                                <!-- Date -->
                                <div>
                                    <x-input-label for="date" :value="__('Tanggal')" />
                                    <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', $archive->date?->format('Y-m-d'))" />
                                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                                </div>

                                <!-- Type -->
                                <div>
                                    <x-input-label for="type" :value="__('Tipe')" />
                                    <x-text-input id="type" class="block mt-1 w-full" type="text" name="type" :value="old('type', $archive->type)" />
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>

                                <!-- Format -->
                                <div>
                                    <x-input-label for="format" :value="__('Format')" />
                                    <x-text-input id="format" class="block mt-1 w-full" type="text" name="format" :value="old('format', $archive->format)" />
                                    <x-input-error :messages="$errors->get('format')" class="mt-2" />
                                </div>

                                <!-- Identifier -->
                                <div>
                                    <x-input-label for="identifier" :value="__('Identifikasi')" />
                                    <x-text-input id="identifier" class="block mt-1 w-full" type="text" name="identifier" :value="old('identifier', $archive->identifier)" />
                                    <x-input-error :messages="$errors->get('identifier')" class="mt-2" />
                                </div>

                                <!-- Source -->
                                <div>
                                    <x-input-label for="source" :value="__('Sumber')" />
                                    <x-text-input id="source" class="block mt-1 w-full" type="text" name="source" :value="old('source', $archive->source)" />
                                    <x-input-error :messages="$errors->get('source')" class="mt-2" />
                                </div>

                                <!-- Language -->
                                <div>
                                    <x-input-label for="language" :value="__('Bahasa')" />
                                    <x-text-input id="language" class="block mt-1 w-full" type="text" name="language" :value="old('language', $archive->language)" />
                                    <x-input-error :messages="$errors->get('language')" class="mt-2" />
                                </div>

                                <!-- Relation -->
                                <div>
                                    <x-input-label for="relation" :value="__('Relasi')" />
                                    <x-text-input id="relation" class="block mt-1 w-full" type="text" name="relation" :value="old('relation', $archive->relation)" />
                                    <x-input-error :messages="$errors->get('relation')" class="mt-2" />
                                </div>

                                <!-- Coverage -->
                                <div>
                                    <x-input-label for="coverage" :value="__('Cakupan')" />
                                    <x-text-input id="coverage" class="block mt-1 w-full" type="text" name="coverage" :value="old('coverage', $archive->coverage)" />
                                    <x-input-error :messages="$errors->get('coverage')" class="mt-2" />
                                </div>

                                <!-- Rights -->
                                <div>
                                    <x-input-label for="rights" :value="__('Hak Cipta')" />
                                    <x-text-input id="rights" class="block mt-1 w-full" type="text" name="rights" :value="old('rights', $archive->rights)" />
                                    <x-input-error :messages="$errors->get('rights')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <a href="{{ route('archive.show', $archive) }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                                {{ __('Kembali') }}
                            </a>
                            <x-primary-button>
                                {{ __('Perbarui Arsip') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            Array.from(this.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${event.target.result}" alt="Preview" class="w-full h-24 object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                        <span class="absolute top-2 right-2 bg-blue-600 text-white px-2 py-1 rounded text-sm">+${index + 1}</span>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
</x-app-layout>
