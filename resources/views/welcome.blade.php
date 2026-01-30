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

    <!-- Dark Mode Initialization -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-white dark:bg-gray-900 antialiased font-['Instrument_Sans']">

    <x-nav-guest />

    <main class="min-h-screen">

        {{-- ================= HERO CAROUSEL ================= --}}
        @if ($heroSlides->count())

            <section x-data="{
                                active: 0,
                                slides: @js(
                                    $heroSlides->map(fn($slide) => [
                                        'image' => asset('storage/' . $slide->image),
                                        'title' => $slide->title,
                                        'desc' => $slide->description,
                                    ])
                                ),
                                init() {
                                    if (this.slides.length > 1) {
                                        setInterval(() => {
                                            this.active = (this.active + 1) % this.slides.length
                                        }, 4000)
                                    }
                                }
                            }" class="relative h-[420px] overflow-hidden" @mouseenter="paused = true"
                @mouseleave="paused = false">

                {{-- SLIDES --}}
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="active === index" x-transition:enter="transition-opacity duration-700"
                        x-transition:leave="transition-opacity duration-700" class="absolute inset-0">
                        {{-- BACKGROUND IMAGE --}}
                        <div class="absolute inset-0 bg-cover bg-center" :style="`background-image: url(${slide.image})`">
                        </div>

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-blue-700/70"></div>

                        {{-- CONTENT --}}
                        <div class="relative max-w-7xl mx-auto px-6 h-full flex items-center">
                            <div class="max-w-3xl text-white">
                                <h1 class="text-4xl md:text-5xl font-bold mb-4" x-text="slide.title"></h1>

                                <p class="text-lg md:text-xl text-blue-100" x-text="slide.desc"></p>
                            </div>
                        </div>
                    </div>
                </template>

                {{-- INDICATORS --}}
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2" x-show="slides.length > 1">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="active = index" class="w-3 h-3 rounded-full transition-all duration-300"
                            :class="active === index ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white/70'"></button>
                    </template>
                </div>

            </section>

        @else

            {{-- ================= FALLBACK HERO ================= --}}
            <section class="bg-gradient-to-r from-blue-800 to-blue-900 text-white pt-20 pb-28">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="max-w-4xl">
                        <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-4">
                            Digital Collection
                        </h1>

                        <p class="text-lg md:text-xl text-blue-100 mb-10 max-w-2xl">
                            Platform arsip digital untuk referensi akademik dan umum.
                            Jelajahi koleksi arsip secara mudah dan terstruktur.
                        </p>
                    </div>
                </div>
            </section>

        @endif


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
                            <a href="{{ route('jelajah', ['filter' => $type]) }}" class="group block">

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
                        <a href="{{ route('jelajah') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full
                                                  bg-blue-600 text-white font-semibold
                                                  hover:bg-blue-700 transition shadow">
                            Jelajahi Semua Koleksi
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
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

    <x-footer />

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