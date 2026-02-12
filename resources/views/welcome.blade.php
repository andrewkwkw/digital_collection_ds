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
    <link rel="icon" href="{{ asset('storage/assets/Unpak.png') }}">

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

<body class="bg-gray-50 dark:bg-brand-25 antialiased font-['Instrument_Sans'] text-gray-800 dark:text-gray-200">

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
        <section class="py-20 bg-gray-50 dark:bg-brand-25 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Header --}}
                <div class="mb-12">
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Koleksi Kami
                    </h3>
                    <p class="text-base md:text-lg text-gray-600 dark:text-gray-400 mb-6 max-w-2xl">
                        Temukan berbagai jenis dokumen dalam satu wadah terintegrasi. Dari referensi akademik hingga
                        materi publik yang tersimpan rapi.
                    <div class="w-full h-0.5 bg-brand-600 dark:bg-brand-400 rounded-full"></div>
                </div>

                @if ($archivesByType->count())

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

                        @foreach ($archivesByType as $type => $archives)
                            @php
                                $archive = $archives->first();
                            @endphp

                            {{-- ⬇️ CARD ITEM --}}
                            <a href="{{ route('jelajah', ['filter' => $type]) }}"
                                class="group relative bg-brand-100 dark:bg-brand-900 rounded-2xl shadow-sm hover:shadow-xl hover:shadow-brand-900/10 border border-brand-200 dark:border-brand-800 overflow-hidden transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">
                                {{-- Image / Preview Area --}}
                                <div
                                    class="relative aspect-[16/9] w-full bg-brand-50 dark:bg-gray-900/50 overflow-hidden border-b border-gray-100 dark:border-gray-700">
                                    @if ($archive->files->count())
                                        <div class="pdf-thumb w-full h-full opacity-90 group-hover:opacity-100 transition-opacity duration-300 scale-100 group-hover:scale-105 transition-transform"
                                            data-pdf="{{ asset('storage/' . $archive->files->first()->archive_path) }}">
                                            <canvas></canvas>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center justify-center h-full text-gray-400 gap-2">
                                            <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <span class="text-xs font-medium">Preview Tidak Tersedia</span>
                                        </div>
                                    @endif

                                    {{-- Hover Overlay --}}
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-brand-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                                    </div>
                                </div>

                                {{-- Card Content --}}
                                <div class="p-6 flex-1 flex flex-col items-center justify-center text-center">
                                    <div
                                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-brand-50 dark:bg-brand-25 text-brand-600 dark:text-brand-400 mb-4 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>

                                    <h4
                                        class="text-lg font-bold text-gray-800 dark:text-gray-100 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">
                                        {{ $type ?? 'Uncategorized' }}
                                    </h4>

                                    <span class="mt-2 text-xs font-medium text-gray-500 dark:text-gray-400">
                                        Lihat semua koleksi
                                    </span>
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