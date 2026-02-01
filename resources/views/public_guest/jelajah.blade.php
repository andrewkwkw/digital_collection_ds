<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Jelajah Arsip - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|playfair-display:400,600" rel="stylesheet" />

    {{-- PDF.js Library --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Fallback jika vite belum build --}}
    @endif

    <style>
        .pdf-thumb {
            position: relative;
            overflow: hidden;
        }
        .pdf-thumb canvas {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top; /* Fokus ke bagian atas dokumen */
            transition: transform 0.5s ease;
        }
        /* Efek zoom saat card di-hover */
        .group:hover .pdf-thumb canvas {
            transform: scale(1.05);
        }
    </style>

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-brand-50/50 dark:bg-brand-25 antialiased font-['Instrument_Sans'] flex flex-col min-h-screen">

    <x-nav-guest />

    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            {{-- HEADER SECTION --}}
<div class="mb-10 text-center sm:text-left">
    <h1 class="text-3xl md:text-4xl font-bold text-brand-25 dark:text-brand-50 mb-3">
        Jelajahi Koleksi
    </h1>
    <p class="text-gray-600 dark:text-gray-400 max-w-2xl">
        Jelajahi arsip digital kami. Gunakan fitur filter dan pencarian untuk menemukan referensi akademik yang Anda butuhkan dengan cepat.
    </p>

    {{-- Search Result Indicator --}}
    @if($search || $filter)
        <div class="mt-6 inline-flex items-center px-4 py-2 rounded-lg bg-brand-100 dark:bg-brand-900/50 border border-brand-200 dark:border-brand-700 text-brand-800 dark:text-brand-200 text-sm">
            <svg class="w-4 h-4 mr-2 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <span>
                Menampilkan hasil
                @if($search) untuk "<strong>{{ $search }}</strong>" @endif
                @if($filter) pada kategori "<strong>{{ $filter }}</strong>" @endif
            </span>
            <a href="{{ route('jelajah') }}" class="ml-3 text-brand-600 hover:text-brand-800 dark:hover:text-brand-400 font-semibold underline">Reset</a>
        </div>
    @endif
    <div class="w-full h-0.5 bg-brand-600 dark:bg-brand-400 rounded-full mt-8"></div>
</div>

            {{-- CONTENT GRID --}}
            @if ($archives->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

                    @foreach ($archives as $archive)
                        <a href="{{ route('archive.show-guest', $archive->id) }}" 
                           class="group relative bg-brand-100 dark:bg-brand-900 rounded-2xl shadow-sm hover:shadow-xl hover:shadow-brand-900/10 border border-brand-200 dark:border-brand-800 overflow-hidden transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">
                            
                            {{-- THUMBNAIL AREA --}}
                            <div class="aspect-[16/9] w-full bg-brand-50 dark:bg-brand-950 relative border-b border-brand-100 dark:border-brand-800 overflow-hidden">
                                
                                @if ($archive->files->count())
                                    <div class="pdf-thumb w-full h-full relative" data-pdf="{{ asset('storage/' . $archive->files->first()->archive_path) }}">
                                        {{-- Loading Spinner (Hilang setelah render) --}}
                                        <div class="loading-spinner absolute inset-0 flex items-center justify-center bg-brand-50 dark:bg-brand-900 z-10">
                                            <svg class="animate-spin h-6 w-6 text-brand-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </div>
                                        <canvas class="relative z-0"></canvas>
                                    </div>
                                @else
                                    {{-- Fallback No Preview --}}
                                    <div class="w-full h-full flex flex-col items-center justify-center text-brand-300 dark:text-brand-700 p-4 text-center">
                                        <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <span class="text-xs font-medium">Tidak ada pratinjau</span>
                                    </div>
                                @endif

                                {{-- Overlay Gradient on Hover --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-brand-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                                    <span class="px-4 py-2 bg-white/90 dark:bg-brand-950/90 text-brand-900 dark:text-brand-100 text-xs font-bold rounded-full shadow-lg backdrop-blur-sm transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                        Lihat Detail
                                    </span>
                                </div>
                            </div>

                            {{-- CARD CONTENT --}}
                            <div class="p-5 flex flex-col flex-grow">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <span class="px-2 py-1 rounded bg-brand-50 dark:bg-brand-950 border border-brand-100 dark:border-brand-700 text-[10px] font-bold uppercase tracking-wider text-brand-600 dark:text-brand-400">
                                        {{ $archive->type ?? 'Dokumen' }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        {{ $archive->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-snug mb-2 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors line-clamp-2" title="{{ $archive->title }}">
                                    {{ $archive->title }}
                                </h3>

                                <div class="mt-auto pt-4 flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-brand-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    {{ $archive->files->count() }} Lampiran
                                </div>
                            </div>
                        </a>
                    @endforeach

                </div>

                {{-- PAGINATION --}}
                <div class="mt-12">
                    {{ $archives->links() }}
                </div>

            @else
                {{-- EMPTY STATE --}}
                <div class="flex flex-col items-center justify-center py-20 bg-white dark:bg-brand-900 rounded-3xl border border-brand-100 dark:border-brand-800 text-center shadow-sm">
                    <div class="w-20 h-20 bg-brand-50 dark:bg-brand-800 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Tidak ada arsip ditemukan</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                        Coba gunakan kata kunci lain atau hapus filter pencarian Anda untuk melihat lebih banyak hasil.
                    </p>
                    <a href="{{ route('archive.explore') }}" class="mt-6 px-6 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-lg font-medium transition-colors">
                        Reset Pencarian
                    </a>
                </div>
            @endif

        </div>
    </main>

    <x-footer />

    {{-- SCRIPT: PDF THUMBNAIL GENERATOR --}}
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        document.addEventListener('DOMContentLoaded', () => {
            const thumbs = document.querySelectorAll('.pdf-thumb');
            
            // IntersectionObserver untuk Lazy Loading (Hanya render jika terlihat di layar)
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        renderThumbnail(el);
                        obs.unobserve(el);
                    }
                });
            }, { rootMargin: "100px" });

            thumbs.forEach(el => observer.observe(el));
        });

        function renderThumbnail(el) {
            const url = el.dataset.pdf;
            const canvas = el.querySelector('canvas');
            const spinner = el.querySelector('.loading-spinner');
            
            if (!url || !canvas) return;

            pdfjsLib.getDocument(url).promise
                .then(pdf => pdf.getPage(1))
                .then(page => {
                    // Render skala kecil untuk thumbnail agar performa ringan
                    const scale = 1.0; 
                    const viewport = page.getViewport({ scale: scale });

                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    const renderContext = {
                        canvasContext: canvas.getContext('2d'),
                        viewport: viewport
                    };

                    return page.render(renderContext).promise;
                })
                .then(() => {
                    // Sembunyikan spinner setelah selesai
                    if(spinner) spinner.style.display = 'none';
                })
                .catch(err => {
                    console.error('Thumbnail error:', err);
                    if(spinner) spinner.innerHTML = '<span class="text-[10px] text-red-400">Error</span>';
                });
        }
    </script>

</body>
</html>