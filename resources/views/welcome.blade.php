<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Digital Collection') }}</title>

    {{-- PDF.JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .pdf-thumb canvas {
            width: 100%;
            height: 100%;
            object-fit: cover;
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

<body class="bg-gray-50 dark:bg-gray-900 antialiased font-['Instrument_Sans'] text-gray-800 dark:text-gray-200">

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
                                        }, 5000)
                                    }
                                }
                            }" class="relative h-[500px] overflow-hidden group" @mouseenter="paused = true"
                @mouseleave="paused = false">

                {{-- SLIDES --}}
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="active === index" x-transition:enter="transition-opacity ease-out duration-1000"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity ease-in duration-1000" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="absolute inset-0">

                        {{-- BACKGROUND IMAGE --}}
                        <div class="absolute inset-0 bg-cover bg-center transform transition-transform duration-[5000ms] ease-linear scale-100"
                            :class="active === index ? 'scale-105' : 'scale-100'"
                            :style="`background-image: url(${slide.image})`">
                        </div>

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/95 via-brand-900/80 to-transparent">
                        </div>

                        {{-- CONTENT --}}
                        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
                            <div class="max-w-2xl text-white pt-10">
                                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight" x-text="slide.title"></h1>
                                <p class="text-lg md:text-xl text-gray-200 font-light leading-relaxed max-w-xl"
                                    x-text="slide.desc"></p>
                            </div>
                        </div>
                    </div>
                </template>

                {{-- INDICATORS --}}
                <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3" x-show="slides.length > 1">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="active = index" class="h-1.5 rounded-full transition-all duration-300 shadow-sm"
                            :class="active === index ? 'w-8 bg-brand-400' : 'w-2 bg-white/30 hover:bg-white/60'">
                        </button>
                    </template>
                </div>

            </section>

        @else

            {{-- ================= FALLBACK HERO ================= --}}
            <section
                class="relative bg-gradient-to-br from-gray-900 via-brand-900 to-brand-800 text-white pt-32 pb-40 overflow-hidden">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-brand-500 opacity-20 blur-3xl">
                </div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-blue-900 opacity-20 blur-3xl">
                </div>

                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-brand-100 text-xs font-bold uppercase tracking-widest mb-6 backdrop-blur-md">
                        Universitas Pakuan
                    </span>
                    <h1 class="text-5xl md:text-7xl font-bold tracking-tight mb-6">
                        Digital Collection
                    </h1>
                    <p class="text-lg md:text-xl text-brand-100 mb-10 max-w-2xl mx-auto leading-relaxed">
                        Platform arsip digital terintegrasi untuk referensi akademik dan umum.
                        Jelajahi khazanah pengetahuan secara mudah dan terstruktur.
                    </p>
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('jelajah') }}"
                            class="px-8 py-3 bg-white text-brand-700 font-bold rounded-full hover:bg-brand-50 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                            Mulai Menjelajah
                        </a>
                    </div>
                </div>
            </section>

        @endif


        {{-- ================= KOLEKSI ================= --}}
        <section class="py-20 bg-gray-50 dark:bg-gray-900 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Header --}}
                <div class="mb-12">
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Jelajahi Koleksi Kami
                    </h3>
                    <div class="w-full h-1 bg-brand-600 dark:bg-brand-400 rounded-full"></div>
                </div>

                @if ($archivesByType->count())

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                        @foreach ($archivesByType as $type => $archives)
                            @php
                                $archive = $archives->first();
                            @endphp

                            {{-- ⬇️ CARD ITEM: Ukuran Asli (16:9 + Teks Bawah) tapi Modern --}}
                            <a href="{{ route('jelajah', ['filter' => $type]) }}" class="group block cursor-pointer">

                                {{-- Image Wrapper (Rasio 16:9 dipertahankan) --}}
                                <div
                                    class="relative aspect-[16/9] bg-white dark:bg-gray-800 overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700 group-hover:shadow-xl group-hover:shadow-brand-500/20 group-hover:border-brand-200 transition-all duration-300 transform group-hover:-translate-y-1">

                                    @if ($archive->files->count())
                                        {{-- PDF Canvas --}}
                                        <div class="pdf-thumb w-full h-full group-hover:scale-105 transition-transform duration-500"
                                            data-pdf="{{ asset('storage/' . $archive->files->first()->archive_path) }}">
                                            <canvas></canvas>
                                        </div>
                                    @else
                                        {{-- Fallback --}}
                                        <div
                                            class="flex flex-col items-center justify-center h-full text-gray-400 gap-2 bg-gray-50 dark:bg-gray-800">
                                            <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span class="text-[10px] font-medium uppercase tracking-wider">Preview N/A</span>
                                        </div>
                                    @endif

                                    {{-- Overlay Sage Green Halus --}}
                                    <div
                                        class="absolute inset-0 bg-brand-900 opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                                    </div>

                                    {{-- Tombol "Lihat" muncul saat hover di tengah --}}
                                    <div
                                        class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-90 group-hover:scale-100">
                                        <span
                                            class="bg-white/90 dark:bg-white/90 backdrop-blur text-brand-700 dark:text-brand-300 px-4 py-2 rounded-full text-xs font-bold shadow-lg">
                                            Buka Koleksi
                                        </span>
                                    </div>
                                </div>

                                {{-- Text Area (Di Bawah, seperti asli, tapi di-style) --}}
                                <div class="mt-4 text-center">
                                    <h4
                                        class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">
                                        {{ $type ?? 'Uncategorized' }}
                                        {{-- Panah kecil muncul saat hover --}}
                                        <svg class="w-4 h-4 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M8 6.82v10.36c0 .79.87 1.27 1.54.84l8.14-5.18a1 1 0 0 0 0-1.69L9.54 5.98A.998.998 0 0 0 8 6.82" />
                                        </svg>
                                    </h4>
                                </div>
                            </a>
                        @endforeach

                    </div>

                    {{-- ⬇️ JELAJAH SEMUA BUTTON --}}
                    <div class="mt-16 text-center">
                        <a href="{{ route('jelajah') }}"
                            class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-brand-600 text-white font-semibold text-sm hover:bg-brand-700 transition-all shadow-lg shadow-brand-500/30 hover:-translate-y-1">
                            <span>Jelajahi Semua Koleksi</span>
                        </a>
                    </div>

                @else
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-full mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada koleksi arsip yang tersedia.</p>
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