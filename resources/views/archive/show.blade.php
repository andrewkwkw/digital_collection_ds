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
                            <div class="flex items-center gap-3 p-3 bg-gray-100 dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600">
                                <span class="text-red-600 font-bold">PDF</span>
                                <a href="{{ asset('storage/' . $file->archive_path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline flex-1">
                                    {{ $file->original_filename ?? basename($file->archive_path) }}
                                </a>
                                <a href="{{ asset('storage/' . $file->archive_path) }}" download class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">{{ __('Download') }}</a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Metadata -->
                    <div class="space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if ($archive->creator)
                            <div>
                                <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Pembuat') }}</dt>
                                <dd class="text-gray-600 dark:text-gray-400">{{ $archive->creator }}</dd>
                            </div>
                            @endif

                            @if ($archive->date)
                            <div>
                                <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Tanggal') }}</dt>
                                <dd class="text-gray-600 dark:text-gray-400">{{ $archive->date->format('d F Y') }}</dd>
                            </div>
                            @endif

                            @if ($archive->type)
                            <div>
                                <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Tipe') }}</dt>
                                <dd class="text-gray-600 dark:text-gray-400">{{ $archive->type }}</dd>
                            </div>
                            @endif

                            @if ($archive->format)
                            <div>
                                <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Format') }}</dt>
                                <dd class="text-gray-600 dark:text-gray-400">{{ $archive->format }}</dd>
                            </div>
                            @endif

                            @if ($archive->publisher)
                            <div>
                                <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Penerbit') }}</dt>
                                <dd class="text-gray-600 dark:text-gray-400">{{ $archive->publisher }}</dd>
                            </div>
                            @endif

                            @if ($archive->source)
                            <div>
                                <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Sumber') }}</dt>
                                <dd class="text-gray-600 dark:text-gray-400">{{ $archive->source }}</dd>
                            </div>
                            @endif
                        </div>

                        @if ($archive->subject)
                        <div>
                            <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Subjek') }}</dt>
                            <dd class="text-gray-600 dark:text-gray-400">{{ $archive->subject }}</dd>
                        </div>
                        @endif

                        @if ($archive->description)
                        <div>
                            <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Deskripsi') }}</dt>
                            <dd class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $archive->description }}</dd>
                        </div>
                        @endif

                        @if ($archive->contributor)
                        <div>
                            <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Kontributor') }}</dt>
                            <dd class="text-gray-600 dark:text-gray-400">{{ $archive->contributor }}</dd>
                        </div>
                        @endif

                        @if ($archive->relation)
                        <div>
                            <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Relasi') }}</dt>
                            <dd class="text-gray-600 dark:text-gray-400">{{ $archive->relation }}</dd>
                        </div>
                        @endif

                        @if ($archive->coverage)
                        <div>
                            <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Cakupan') }}</dt>
                            <dd class="text-gray-600 dark:text-gray-400">{{ $archive->coverage }}</dd>
                        </div>
                        @endif

                        @if ($archive->rights)
                        <div>
                            <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Hak Cipta') }}</dt>
                            <dd class="text-gray-600 dark:text-gray-400">{{ $archive->rights }}</dd>
                        </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('archive.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                            {{ __('Kembali') }}
                        </a>
                        <div class="flex gap-2">
                            <a href="{{ route('archive.edit', $archive) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('archive.destroy', $archive) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700" onclick="return confirm('Yakin ingin menghapus?')">
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