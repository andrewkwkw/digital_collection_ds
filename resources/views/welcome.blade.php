<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            @layer theme {}
        </style>
    @endif

    <style>
        .pdf-thumb canvas {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body class="bg-white dark:bg-gray-900 antialiased">
    <x-nav-guest />

    <main class="min-h-screen">
        <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-bold mb-4">Digital Collection</h1>
                <p class="text-lg mb-6 max-w-3xl text-blue-100">
                    Platform arsip digital untuk referensi akademik dan umum. Jelajahi berbagai koleksi yang telah dikurasi dengan cermat.
                </p>
                <div class="flex gap-4">
                    @auth
                        <a href="{{ route('archive.index') }}" class="bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                            Kelola Arsip Saya
                        </a>
                    @endauth
                    <a href="#recent" class="border-2 border-white px-6 py-2 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                        Lihat Koleksi
                    </a>
                </div>
            </div>
        </section>

        @if ($recentArchives->count() > 0)
            <section id="recent" class="py-16 bg-gray-50 dark:bg-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Arsip Terbaru</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                        @foreach ($recentArchives as $archive)
                            <a href="{{ route('archive.show-guest', $archive->id) }}" class="bg-white dark:bg-gray-700 rounded-lg shadow-md hover:shadow-lg transition overflow-hidden group">
                                
                                @if ($archive->files->count() > 0)
                                    <div class="h-48 bg-gray-200 dark:bg-gray-600 pdf-thumb flex items-center justify-center overflow-hidden"
                                         data-pdf="{{ asset('storage/' . $archive->files->first()->archive_path) }}">
                                        <canvas></canvas>
                                    </div>
                                @else
                                    <div class="h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                                        </svg>
                                    </div>
                                @endif

                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-600">{{ $archive->title }}</h3>
                                    <p class="text-xs text-gray-500">{{ $archive->created_at->format('d M Y') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Jelajahi Koleksi</h2>

                <div class="mb-8 bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md border dark:border-gray-600">
                    <form method="GET" action="{{ route('welcome') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari Judul</label>
                                <input type="text" name="search" value="{{ $search }}" placeholder="Masukkan judul..." 
                                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-600 dark:text-white dark:border-gray-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter Tipe</label>
                                <select name="filter" class="w-full px-4 py-2 border rounded-lg dark:bg-gray-600 dark:text-white dark:border-gray-500">
                                    <option value="">Semua Koleksi</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type }}" {{ $filter === $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Cari</button>
                            </div>
                        </div>
                        @if ($search || $filter)
                            <a href="{{ route('welcome') }}" class="inline-block text-blue-600 dark:text-blue-400 text-sm hover:underline">← Bersihkan Filter</a>
                        @endif
                    </form>
                </div>

                @if ($archivesByType->count() > 0)
                    @foreach ($archivesByType as $type => $archives)
                        <div class="mb-12">
                            <div class="flex items-center mb-6 border-b pb-2 dark:border-gray-700">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $type ?? 'Tanpa Kategori' }}</h3>
                                <span class="ml-3 bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-bold">{{ $archives->count() }} Item</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                @foreach ($archives as $archive)
                                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden flex flex-col group">
                                        @if ($archive->files->count() > 0)
                                            <div class="h-56 bg-gray-200 dark:bg-gray-600 relative pdf-thumb overflow-hidden flex items-center justify-center"
                                                 data-pdf="{{ asset('storage/' . $archive->files->first()->archive_path) }}">
                                                <canvas></canvas>
                                            </div>
                                        @else
                                            <div class="h-56 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4z"></path>
                                                </svg>
                                            </div>
                                        @endif

                                        <div class="p-5 flex-grow">
                                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $archive->title }}</h4>
                                            <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $archive->description ?? 'Tidak ada deskripsi.' }}</p>
                                            
                                            <a href="{{ route('archive.show-guest', $archive->id) }}" 
                                               class="block text-center bg-blue-600 text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-20 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-gray-500">Tidak ada arsip ditemukan.</p>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        async function renderThumbnails() {
            const thumbs = document.querySelectorAll('.pdf-thumb');
            
            for (const el of thumbs) {
                const url = el.dataset.pdf;
                const canvas = el.querySelector('canvas');
                if (!url || !canvas) continue;

                const ctx = canvas.getContext('2d');

                try {
                    const loadingTask = pdfjsLib.getDocument(url);
                    const pdf = await loadingTask.promise;
                    const page = await pdf.getPage(1);
                    
                    const viewport = page.getViewport({ scale: 0.8 });
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    await page.render({ canvasContext: ctx, viewport: viewport }).promise;
                } catch (e) {
                    console.error("Gagal memuat PDF:", e);
                    el.innerHTML = '<div class="text-xs text-gray-400">Preview N/A</div>';
                }
            }
        }

        // Jalankan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', renderThumbnails);
    </script>
</body>
</html>