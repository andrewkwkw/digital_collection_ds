<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ $archive->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($archive->files->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">{{ __('File PDF') }}</h3>
                            <div class="space-y-2">
                                @foreach ($archive->files as $file)
                                    <div
                                        class="flex items-center gap-3 p-3 bg-gray-100 dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600">
                                        <span class="text-red-600 font-bold">PDF</span>

                                        <a href="{{ asset('storage/' . $file->archive_path) }}" target="_blank"
                                            class="text-blue-600 dark:text-blue-400 hover:underline flex-1">
                                            {{ $file->original_filename ?? basename($file->archive_path) }}
                                        </a>

                                        <a href="{{ route('archive.show_file', $file->id) }}"
                                            class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ __('Lihat File') }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Metadata -->
                    <x-archive-details :archive="$archive" :canEdit="true" />

                    <!-- Actions -->
                    <div
                        class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('archive.index') }}"
                            class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                            {{ __('Kembali') }}
                        </a>
                        <div class="flex gap-2">
                            <a href="{{ route('archive.edit', $archive) }}"
                                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('archive.destroy', $archive) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                                    onclick="return confirm('Yakin ingin menghapus?')">
                                    {{ __('Hapus') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>