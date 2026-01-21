<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Daftar Arsip') }}
            </h2>
            <a href="{{ route('archive.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                {{ __('Upload Arsip Baru') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded dark:bg-green-900 dark:border-green-600 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if ($archives->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($archives as $archive)
                        <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                            <!-- Content -->
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 truncate">
                                    {{ $archive->title }}
                                </h3>
                                @if ($archive->creator)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $archive->creator }}</p>
                                @endif
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                    {{ $archive->created_at->format('d M Y') }}
                                </p>

                                <!-- Actions -->
                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('archive.show', $archive->id) }}" class="flex-1 text-center px-3 py-2 text-sm bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded hover:bg-blue-200 dark:hover:bg-blue-800">
                                        Lihat
                                    </a>
                                    <a href="{{ route('archive.edit', $archive) }}" class="flex-1 text-center px-3 py-2 text-sm bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 rounded hover:bg-yellow-200 dark:hover:bg-yellow-800">
                                        Edit
                                    </a>
                                    <form action="{{ route('archive.destroy', $archive) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-3 py-2 text-sm bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded hover:bg-red-200 dark:hover:bg-red-800" onclick="return confirm('Yakin ingin menghapus?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $archives->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                        <p class="text-gray-500 dark:text-gray-400">{{ __('Belum ada arsip') }}</p>
                        <a href="{{ route('archive.create') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            {{ __('Upload Arsip Pertama') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
