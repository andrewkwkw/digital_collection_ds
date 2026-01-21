<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600"
        rel="stylesheet"
    />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Tailwind CSS (auto-generated fallback) */
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            @layer theme {

            }
        </style>
    @endif
</head>

<body class="bg-white dark:bg-gray-900">
    <!-- Navigation -->
    <x-nav-guest />

    <!-- Main Content -->
    <main class="min-h-screen">
        <!-- Hero Section with Description -->
        <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-bold mb-4">Digital Collection</h1>
                <p class="text-lg mb-6 max-w-3xl">
                    Selamat datang di platform Digital Collection. Kami menyediakan akses ke koleksi arsip digital yang kaya dan beragam. 
                    Jelajahi berbagai koleksi yang telah dikurasi dengan cermat untuk memberikan nilai edukatif dan referensi bagi peneliti, 
                    akademisi, dan masyarakat umum.
                </p>
                <div class="flex gap-4">
                    @auth
                        <a href="{{ route('archive.index') }}" class="bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100">
                            Kelola Arsip Saya
                        </a>
                    @endauth
                    <a href="#recent" class="border-2 border-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700">
                        Lihat Koleksi
                    </a>
                </div>
            </div>
        </section>

        <!-- Recent Archives Section -->
        @if ($recentArchives->count() > 0)
        <section id="recent" class="py-16 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Arsip Terbaru</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                    @foreach ($recentArchives as $archive)
                    <a href="{{ route('archive.show-guest', $archive->id) }}" class="bg-white dark:bg-gray-700 rounded-lg shadow-md hover:shadow-lg transition overflow-hidden cursor-pointer group">
                        <!-- Thumbnail if available -->
                        @if ($archive->files->count() > 0)
                        <div class="h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center group-hover:bg-gray-300 dark:group-hover:bg-gray-500 transition">
                            <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                            </svg>
                        </div>
                        @else
                        <div class="h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center group-hover:bg-gray-300 dark:group-hover:bg-gray-500 transition">
                            <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2A4 4 0 000 5v10a4 4 0 004 4h12a4 4 0 004-4V5a4 4 0 00-4-4 1 1 0 000 2 2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400">{{ $archive->title }}</h3>
                            @if ($archive->type)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $archive->type }}</p>
                            @endif
                            <p class="text-xs text-gray-500 dark:text-gray-500">{{ $archive->created_at->format('d M Y') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Gallery/Collections Section -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Jelajahi Koleksi</h2>

                <!-- Search and Filter Bar -->
                <div class="mb-8 bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                    <form method="GET" action="{{ route('welcome') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Search by Title -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Cari Judul
                                </label>
                                <input 
                                    type="text" 
                                    id="search" 
                                    name="search" 
                                    value="{{ $search }}"
                                    placeholder="Masukkan judul arsip..." 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                            </div>

                            <!-- Filter by Collection/Type -->
                            <div>
                                <label for="filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Filter Koleksi
                                </label>
                                <select 
                                    id="filter" 
                                    name="filter" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                    <option value="">Semua Koleksi</option>
                                    @foreach ($types as $type)
                                    <option value="{{ $type }}" {{ $filter === $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-end">
                                <button 
                                    type="submit" 
                                    class="w-full bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition"
                                >
                                    Cari
                                </button>
                            </div>
                        </div>

                        <!-- Clear Filters Button -->
                        @if ($search || $filter)
                        <div>
                            <a 
                                href="{{ route('welcome') }}" 
                                class="inline-block text-blue-600 dark:text-blue-400 hover:underline text-sm"
                            >
                                ← Hapus Filter
                            </a>
                        </div>
                        @endif
                    </form>
                </div>

                <!-- Archives Grouped by Type -->
                @if ($archivesByType->count() > 0)
                    @foreach ($archivesByType as $type => $archives)
                    <div class="mb-12">
                        <div class="flex items-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $type ?? 'Tanpa Kategori' }}
                            </h3>
                            <span class="ml-3 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $archives->count() }} item
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($archives as $archive)
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md hover:shadow-xl transition-shadow overflow-hidden group">
                                <!-- Thumbnail -->
                                <div class="h-56 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center relative overflow-hidden">
                                    @if ($archive->files->count() > 0)
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                                        </svg>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="p-5">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                        {{ $archive->title }}
                                    </h4>

                                    @if ($archive->creator)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        <span class="font-medium">Pembuat:</span> {{ $archive->creator }}
                                    </p>
                                    @endif

                                    @if ($archive->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                                        {{ $archive->description }}
                                    </p>
                                    @endif

                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-500 mb-4">
                                        <span>{{ $archive->created_at->format('d M Y') }}</span>
                                        @if ($archive->files->count() > 0)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5z"></path>
                                            </svg>
                                            {{ $archive->files->count() }}
                                        </span>
                                        @endif
                                    </div>

                                    <!-- View Button -->
                                    @auth
                                    <a 
                                        href="{{ route('archive.show', $archive->id) }}" 
                                        class="w-full block text-center bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition text-sm"
                                    >
                                        Lihat Detail
                                    </a>
                                    @else
                                    <a 
                                        href="{{ route('archive.show-guest', $archive->id) }}" 
                                        class="w-full block text-center bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition text-sm"
                                    >
                                        Lihat Detail
                                    </a>
                                    @endauth
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="bg-white dark:bg-gray-700 rounded-lg p-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2A4 4 0 000 5v10a4 4 0 004 4h12a4 4 0 004-4V5a4 4 0 00-4-4 1 1 0 000 2 2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z" clip-rule="evenodd"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Tidak Ada Arsip</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ $search || $filter ? 'Tidak ada arsip yang sesuai dengan filter atau pencarian Anda.' : 'Belum ada arsip yang diupload.' }}
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </main>
</body>
</html>
