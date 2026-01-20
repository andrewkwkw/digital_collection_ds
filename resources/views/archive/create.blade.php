<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Upload Arsip Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('archive.store') }}" enctype="multipart/form-data" id="archiveForm">
                        @csrf

                        <!-- Documents Upload -->
                        <div class="mb-6">
                            <label for="documents" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Upload PDF (required, minimal 1, maksimal 100MB per file)') }}
                            </label>
                            <div class="mt-2">
                                <input type="file" id="documents" name="documents[]" multiple accept="application/pdf" required
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                                    file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                                    file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900
                                    file:text-blue-700 dark:file:text-blue-200 hover:file:bg-blue-100 dark:hover:file:bg-blue-800" />
                            </div>
                            <div id="documentList" class="mt-4 space-y-2"></div>
                            <x-input-error :messages="$errors->get('documents')" class="mt-2" />
                            <x-input-error :messages="$errors->get('documents.*')" class="mt-2" />
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-6">{{ __('Metadata') }}</h3>

                            <!-- Title -->
                            <div class="mb-4">
                                <x-input-label for="title" :value="__('Judul')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Creator -->
                            <div class="mb-4">
                                <x-input-label for="creator" :value="__('Creator')" />
                                <x-text-input id="creator" class="block mt-1 w-full" type="text" name="creator" :value="old('creator')" />
                                <x-input-error :messages="$errors->get('creator')" class="mt-2" />
                            </div>

                            <!-- Subject -->
                            <div class="mb-4">
                                <x-input-label for="subject" :value="__('Subjek')" />
                                <textarea id="subject" name="subject" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('subject') }}</textarea>
                                <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <x-input-label for="description" :value="__('Deskripsi')" />
                                <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Publisher -->
                                <div>
                                    <x-input-label for="publisher" :value="__('Penerbit')" />
                                    <x-text-input id="publisher" class="block mt-1 w-full" type="text" name="publisher" :value="old('publisher')" />
                                    <x-input-error :messages="$errors->get('publisher')" class="mt-2" />
                                </div>

                                <!-- Contributor -->
                                <div>
                                    <x-input-label for="contributor" :value="__('Kontributor')" />
                                    <x-text-input id="contributor" class="block mt-1 w-full" type="text" name="contributor" :value="old('contributor')" />
                                    <x-input-error :messages="$errors->get('contributor')" class="mt-2" />
                                </div>

                                <!-- Date -->
                                <div>
                                    <x-input-label for="date" :value="__('Tanggal')" />
                                    <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" />
                                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                                </div>

                                <!-- Type -->
                                <div>
                                    <x-input-label for="type" :value="__('Tipe')" />
                                    <x-text-input id="type" class="block mt-1 w-full" type="text" name="type" :value="old('type')" />
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>

                                <!-- Format -->
                                <div>
                                    <x-input-label for="format" :value="__('Format')" />
                                    <x-text-input id="format" class="block mt-1 w-full" type="text" name="format" :value="old('format')" />
                                    <x-input-error :messages="$errors->get('format')" class="mt-2" />
                                </div>

                                <!-- Source -->
                                <div>
                                    <x-input-label for="source" :value="__('Sumber')" />
                                    <x-text-input id="source" class="block mt-1 w-full" type="text" name="source" :value="old('source')" />
                                    <x-input-error :messages="$errors->get('source')" class="mt-2" />
                                </div>

                                <!-- Relation -->
                                <div>
                                    <x-input-label for="relation" :value="__('Relasi')" />
                                    <x-text-input id="relation" class="block mt-1 w-full" type="text" name="relation" :value="old('relation')" />
                                    <x-input-error :messages="$errors->get('relation')" class="mt-2" />
                                </div>

                                <!-- Reach -->
                                <div>
                                    <x-input-label for="reach" :value="__('Jangkauan')" />
                                    <x-text-input id="reach" class="block mt-1 w-full" type="text" name="reach" :value="old('reach')" />
                                    <x-input-error :messages="$errors->get('reach')" class="mt-2" />
                                </div>

                                <!-- Rights -->
                                <div>
                                    <x-input-label for="rights" :value="__('Hak Cipta')" />
                                    <x-text-input id="rights" class="block mt-1 w-full" type="text" name="rights" :value="old('rights')" />
                                    <x-input-error :messages="$errors->get('rights')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('archive.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                                {{ __('Kembali') }}
                            </a>
                            <x-primary-button>
                                {{ __('Upload Arsip') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('images').addEventListener('change', function(e) {
            const docList = document.getElementById('documentList');
            docList.innerHTML = '';
            
            Array.from(this.files).forEach((file, index) => {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between p-2 bg-gray-100 dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600';
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                div.innerHTML = `
                    <div class="flex items-center gap-2">
                        <span class="text-red-600 font-bold">PDF</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${file.name}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">${fileSize} MB</p>
                        </div>
                    </div>
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm">${index + 1}</span>
                `;
                docList.appendChild(div);
            });
        });
    </script>
</x-app-layout>
