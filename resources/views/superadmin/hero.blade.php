<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Hero Carousel
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Kelola konten hero pada halaman utama (maksimal 5 slide).
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- ALERT --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- ================= ADD HERO FORM ================= --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-10">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200">
                Tambah Hero Slide
            </h3>

            @if(session('error'))
                <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.hero.store') }}" enctype="multipart/form-data"
                class="grid md:grid-cols-2 gap-6">
                @csrf

                {{-- IMAGE --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Gambar Hero</label>
                    <input type="file" name="image" required accept="image/*" class="w-full rounded border-gray-300">
                    <p class="text-xs text-gray-500 mt-1">
                        Rekomendasi 1920 × 600 px
                    </p>
                </div>

                {{-- TITLE --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Judul</label>
                    <input type="text" name="title" class="w-full rounded border-gray-300">
                </div>

                {{-- DESCRIPTION --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Deskripsi</label>
                    <input type="text" name="description" class="w-full rounded border-gray-300">
                </div>

                {{-- SUBMIT --}}
                <div class="md:col-span-2">
                    <button class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Upload Hero
                    </button>
                </div>
            </form>
        </div>


        {{-- ================= HERO LIST ================= --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
    
    {{-- HEADER & FORM UTAMA --}}
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold">Daftar Hero Slide</h3>
        
        {{-- Jika ada data, munculkan tombol save all --}}
        @if (!$heroes->isEmpty())
            {{-- Form Wrapper Utama (Hidden Logic) --}}
            <form id="saveOrderForm" action="{{ route('admin.hero.reorder') }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Simpan Semua Urutan
                </button>
            </form>
        @endif
    </div>

    @if ($heroes->isEmpty())
        <p class="text-gray-500">Belum ada hero.</p>
    @else
        <div class="grid md:grid-cols-2 gap-6">
            @foreach ($heroes as $hero)
                <div class="border rounded-lg overflow-hidden relative">

                    {{-- IMAGE --}}
                    <img src="{{ asset('storage/' . $hero->image) }}" class="w-full h-40 object-cover">

                    <div class="p-4">
                        <h4 class="font-semibold">
                            {{ $hero->title ?? 'Tanpa Judul' }}
                        </h4>
                        <p class="text-sm text-gray-500 mb-4">
                            {{ $hero->description ?? '-' }}
                        </p>

                        <div class="flex items-center justify-between mt-4 pt-4 border-t">

                            {{-- ORDER INPUT (Linked to Main Form) --}}
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold text-gray-500 uppercase">Urutan:</span>
                                
                                {{-- PERHATIKAN ATRIBUT FORM DAN NAME --}}
                                <input 
                                    type="number" 
                                    form="saveOrderForm" 
                                    name="orders[{{ $hero->id }}]" 
                                    value="{{ $hero->order }}" 
                                    min="1" 
                                    max="{{ $heroes->count() }}"
                                    class="w-16 border border-gray-300 rounded px-2 py-1 text-center focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>

                            <div class="flex items-center gap-3">
                                {{-- TOGGLE --}}
                                <form action="{{ route('admin.hero.toggle', $hero->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="relative inline-flex h-6 w-11 rounded-full items-center 
                                        {{ $hero->is_active ? 'bg-green-600' : 'bg-gray-300' }}">
                                        <span class="inline-block h-4 w-4 bg-white rounded-full transform transition ml-1
                                            {{ $hero->is_active ? 'translate-x-5' : 'translate-x-0' }}">
                                        </span>
                                    </button>
                                </form>

                                {{-- DELETE --}}
                                <form method="POST" action="{{ route('admin.hero.destroy', $hero->id) }}"
                                    onsubmit="return confirm('Hapus hero ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-sm text-red-600 hover:text-red-800 font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
    </div>
</x-app-layout>