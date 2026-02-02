<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    Hero Carousel
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Kelola banner utama halaman depan (Maksimal 5 Slide).
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span
                    class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300">
                    {{ $heroes->count() }} / 5 Slide Digunakan
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ALERT MESSAGES --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="flex items-center justify-between p-4 mb-4 text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400 rounded-lg shadow-sm border border-green-100 dark:border-green-900">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="opacity-50 hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show"
                    class="flex items-center justify-between p-4 mb-4 text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400 rounded-lg shadow-sm border border-red-100 dark:border-red-900">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="opacity-50 hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8">

                {{-- ================= ADD HERO FORM (LEFT COLUMN) ================= --}}
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 sticky top-8">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Upload Slide Baru
                            </h3>
                        </div>

                        <form method="POST" action="{{ route('admin.hero.store') }}" enctype="multipart/form-data"
                            class="p-6 space-y-5">
                            @csrf

                            {{-- IMAGE UPLOAD --}}
                            <div x-data="{ fileName: '' }">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gambar
                                    Banner</label>
                                <div class="relative group">
                                    <label for="file-upload"
                                        class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-900 hover:bg-white dark:hover:bg-gray-800 hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-300 group-hover:shadow-md">
                                        <div
                                            class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                            <svg class="w-10 h-10 mb-3 text-gray-400 group-hover:text-blue-500 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                </path>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                    class="font-semibold text-blue-600">Klik untuk upload</span></p>
                                            <p class="text-xs text-gray-400"
                                                x-text="fileName ? fileName : 'PNG, JPG, WEBP (Max 2MB)'"></p>
                                            <p class="text-[10px] text-gray-400 mt-1">Saran: 1920x600 px</p>
                                        </div>
                                        <input id="file-upload" name="image" type="file" required accept="image/*"
                                            class="hidden" @change="fileName = $event.target.files[0].name" />
                                    </label>
                                </div>
                            </div>

                            {{-- TITLE --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul
                                    Utama</label>
                                <input type="text" name="title" placeholder="Contoh: Selamat Datang..."
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow text-sm placeholder:text-gray-400">
                            </div>

                            {{-- DESCRIPTION --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi
                                    Singkat</label>
                                <textarea name="description" rows="3" placeholder="Deskripsi pendek untuk slide ini..."
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow text-sm placeholder:text-gray-400"></textarea>
                            </div>

                            <button type="submit"
                                class="w-full py-2.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                                <span>Upload & Simpan</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- ================= HERO LIST (RIGHT COLUMN) ================= --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- HEADER LIST --}}
                    <div
                        class="flex items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="font-bold text-gray-800 dark:text-white">Slide Aktif</h3>

                        @if (!$heroes->isEmpty())
                            <form id="saveOrderForm" action="{{ route('admin.hero.reorder') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center gap-1.5 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                    Update Urutan
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($heroes->isEmpty())
                        <div
                            class="flex flex-col items-center justify-center py-16 bg-white dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                            <div
                                class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4 text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-500 dark:text-gray-400">Belum ada slide hero</h4>
                            <p class="text-sm text-gray-400 mt-1">Upload gambar di sebelah kiri untuk memulai.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($heroes as $hero)
                                <div
                                    class="group bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-700 transition-all duration-300 relative overflow-hidden">
                                    <div class="flex flex-col sm:flex-row gap-5 items-start">

                                        {{-- IMAGE PREVIEW --}}
                                        <div
                                            class="relative w-full sm:w-48 h-32 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                                            <img src="{{ asset('storage/' . $hero->image) }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            @if(!$hero->is_active)
                                                <div
                                                    class="absolute inset-0 bg-black/50 flex items-center justify-center backdrop-blur-sm">
                                                    <span
                                                        class="text-white text-xs font-bold uppercase tracking-wider px-2 py-1 bg-black/20 rounded">Non-Aktif</span>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- CONTENT --}}
                                        <div class="flex-grow min-w-0">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h4 class="font-bold text-gray-900 dark:text-white truncate pr-4 text-lg">
                                                        {{ $hero->title ?? 'Tanpa Judul' }}
                                                    </h4>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mt-1">
                                                        {{ $hero->description ?? 'Tidak ada deskripsi.' }}
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- CONTROLS --}}
                                            <div class="flex flex-wrap items-center gap-4 mt-5">

                                                {{-- ORDER INPUT --}}
                                                <div
                                                    class="flex items-center gap-2 bg-gray-50 dark:bg-gray-700 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-600">
                                                    <span
                                                        class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Urutan</span>
                                                    <input type="number" form="saveOrderForm" name="orders[{{ $hero->id }}]"
                                                        value="{{ $hero->order }}" min="1"
                                                        class="w-12 bg-transparent border-0 p-0 text-center font-bold text-gray-700 dark:text-white focus:ring-0 text-sm">
                                                </div>

                                                <div class="flex-grow"></div>

                                                {{-- ACTIONS --}}
                                                <div class="flex items-center gap-3">
                                                    {{-- DELETE --}}
                                                    <form method="POST" action="{{ route('admin.hero.destroy', $hero->id) }}"
                                                        onsubmit="return confirm('Hapus slide ini secara permanen?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                                            title="Hapus Slide">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1.5"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    {{-- TOGGLE STATUS --}}
                                                    <form action="{{ route('admin.hero.toggle', $hero->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="relative inline-flex h-7 w-12 rounded-full cursor-pointer transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 {{ $hero->is_active ? 'bg-green-500' : 'bg-gray-200 dark:bg-gray-700' }}">
                                                            <span class="sr-only">Toggle status</span>
                                                            <span
                                                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out mt-1 ml-1 {{ $hero->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>