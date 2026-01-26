<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Digital Collection') }}</title>

    {{-- PDF.JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .pdf-thumb canvas {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body class="bg-white dark:bg-gray-900 antialiased font-['Instrument_Sans']">

<x-nav-guest />

<main class="min-h-screen">

    {{-- ================= HERO ================= --}}
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white pt-20 pb-28">
        <div class="max-w-7xl mx-auto px-6">

            <div class="max-w-4xl">
                <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-4">
                    Digital Collection
                </h1>

                <p class="text-lg md:text-xl text-blue-100 mb-10 max-w-2xl">
                    Platform arsip digital untuk referensi akademik dan umum.
                    Jelajahi koleksi terkurasi berdasarkan kategori arsip.
                </p>
            </div>

        </div>
    </section>

    {{-- ================= KOLEKSI ================= --}}
    <section class="py-14 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-8 border-b border-gray-200 dark:border-gray-800 pb-4">
                <h2 class="inline-block bg-blue-900 text-white px-4 py-2 font-bold">
                    Koleksi Arsip
                </h2>
            </div>

            @if ($archivesByType->count())

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                    @foreach ($archivesByType as $type => $archives)
                        @php
                            $archive = $archives->first();
                        @endphp

                        {{-- ⬇️ KLIK TIPE → JELAJAH TER-FILTER --}}
                        <a href="{{ route('jelajah', ['filter' => $type]) }}"
                           class="group block">

                            <div class="relative aspect-[16/9] bg-gray-200 dark:bg-gray-800 overflow-hidden shadow">

                                @if ($archive->files->count())
                                    <div class="pdf-thumb w-full h-full"
                                         data-pdf="{{ asset('storage/' . $archive->files->first()->archive_path) }}">
                                        <canvas></canvas>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400 text-xs">
                                        Preview N/A
                                    </div>
                                @endif

                                <div class="absolute inset-0 bg-blue-900 opacity-0 group-hover:opacity-10 transition"></div>
                            </div>

                            {{-- TYPE ONLY --}}
                            <div class="mt-3 text-center text-xs font-semibold uppercase tracking-widest text-gray-500">
                                {{ $type ?? 'Uncategorized' }}
                            </div>
                        </a>
                    @endforeach

                </div>

                {{-- ⬇️ JELAJAH SEMUA --}}
                <div class="mt-14 text-center">
                    <a href="{{ route('jelajah') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-full
                              bg-blue-600 text-white font-semibold
                              hover:bg-blue-700 transition shadow">
                        Jelajahi Semua Koleksi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

            @else
                <div class="text-center py-20 text-gray-500">
                    Tidak ada koleksi arsip tersedia.
                </div>
            @endif

        </div>
    </section>

</main>

{{-- ================= PDF THUMB ================= --}}
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    document.addEventListener('DOMContentLoaded', () => {
        const thumbs = document.querySelectorAll('.pdf-thumb');

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    renderPdf(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { rootMargin: '100px' });

        thumbs.forEach(el => observer.observe(el));
    });

    async function renderPdf(el) {
        const url = el.dataset.pdf;
        const canvas = el.querySelector('canvas');
        if (!url || !canvas) return;

        try {
            const pdf = await pdfjsLib.getDocument(url).promise;
            const page = await pdf.getPage(1);
            const viewport = page.getViewport({ scale: 1 });

            canvas.width = viewport.width;
            canvas.height = viewport.height;

            await page.render({
                canvasContext: canvas.getContext('2d'),
                viewport
            }).promise;
        } catch {
            el.innerHTML =
                '<div class="flex items-center justify-center h-full text-xs text-gray-400">Preview gagal</div>';
        }
    }
</script>

</body>
</html>
