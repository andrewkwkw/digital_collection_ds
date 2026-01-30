<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

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

    <main class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Jelajahi Koleksi Arsip
                </h1>

                @if($search || $filter)
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Hasil
                        @if($search)
                            untuk judul "<strong>{{ $search }}</strong>"
                        @endif
                        @if($filter)
                            pada tipe "<strong>{{ $filter }}</strong>"
                        @endif
                    </p>
                @endif
            </div>

            {{-- GRID --}}
            @if ($archives->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    @foreach ($archives as $archive)
                        <a href="{{ route('archive.show-guest', $archive->id) }}" class="group block">

                            <div class="relative aspect-[16/9] overflow-hidden
                                                                                    bg-gray-200 dark:bg-gray-800 shadow-sm">

                                @if ($archive->files->count())
                                    <div class="pdf-thumb w-full h-full"
                                        data-pdf="{{ asset('storage/' . $archive->files->first()->archive_path) }}">
                                        <canvas></canvas>
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                                        No Preview
                                    </div>
                                @endif

                                <div class="absolute inset-0 bg-blue-900 opacity-0
                                                                                        group-hover:opacity-10 transition">
                                </div>
                            </div>

                            {{-- TITLE + TYPE --}}
                            <div class="mt-3 text-center space-y-1">

                                {{-- TITLE --}}
                                <div class="text-sm font-semibold text-gray-800 dark:text-gray-100 line-clamp-2">
                                    <span class="font-normal text-gray-500 dark:text-gray-400">
                                        Judul:
                                    </span>
                                    {{ $archive->title }}
                                </div>

                                {{-- TYPE --}}
                                <div class="text-xs uppercase tracking-widest font-semibold
                                                                text-gray-500 dark:text-gray-400">
                                    <span class="font-normal normal-case tracking-normal">
                                        Tipe:
                                    </span>
                                    {{ $archive->type ?? 'Uncategorized' }}
                                </div>

                            </div>

                        </a>
                    @endforeach

                </div>

                {{-- PAGINATION --}}
                <div class="mt-10">
                    {{ $archives->links() }}
                </div>
            @else
                <div class="text-center py-20 text-gray-500 dark:text-gray-400">
                    Tidak ada arsip ditemukan.
                </div>
            @endif

        </div>
    </main>

    <x-footer />

    {{-- PDF.JS --}}
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc =
            'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.pdf-thumb').forEach(el => {
                const url = el.dataset.pdf;
                const canvas = el.querySelector('canvas');
                if (!url || !canvas) return;

                pdfjsLib.getDocument(url).promise
                    .then(pdf => pdf.getPage(1))
                    .then(page => {
                        const viewport = page.getViewport({ scale: 1 });
                        canvas.width = viewport.width;
                        canvas.height = viewport.height;
                        page.render({
                            canvasContext: canvas.getContext('2d'),
                            viewport
                        });
                    });
            });
        });
    </script>

</body>

</html>