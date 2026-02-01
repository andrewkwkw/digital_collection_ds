<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $archive->title }} - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|playfair-display:400,600,700,800" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Fallback jika vite belum di-build, tapi idealnya style diambil dari app.css yang sudah di-compile --}}
    @endif

    {{-- PDF.js Library (Wajib untuk render preview) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>

    <style>
        /* HANYA MENYIMPAN CUSTOM EFFECT YANG TIDAK ADA DI TAILWIND */
        
        /* Efek Shadow Dokumen Realistis (Tumpukan Kertas) */
        .document-shadow {
            box-shadow: 
                0 1px 1px rgba(0,0,0,0.1), 
                0 10px 0 -5px #fff, 
                0 10px 1px -4px rgba(0,0,0,0.1), 
                0 20px 0 -10px #fff, 
                0 20px 1px -9px rgba(0,0,0,0.1);
        }
        
        /* Dark mode adjustment untuk shadow */
        .dark .document-shadow {
            box-shadow: 
                0 1px 1px rgba(0,0,0,0.5), 
                0 10px 0 -5px #1f2937, 
                0 10px 1px -4px rgba(0,0,0,0.5), 
                0 20px 0 -10px #111827, 
                0 20px 1px -9px rgba(0,0,0,0.5);
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

<body class="bg-gray-50 dark:bg-brand-25 antialiased font-['Instrument_Sans'] text-gray-900 dark:text-gray-100 flex flex-col min-h-screen relative">

    <x-nav-guest />

    <main class="flex-grow py-10 px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-8">
                <a href="{{ route('jelajah') }}" 
                   class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-white dark:bg-brand-900 border border-brand-200 dark:border-brand-800 flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </div>
                    Kembali
                </a>
            </div>

            {{-- Menggunakan border-brand-200 sesuai config --}}
            <div class="bg-white dark:bg-brand-25 rounded-[2rem] shadow-xl overflow-hidden border border-brand-200 dark:border-brand-800">
                
                {{-- Decorative Top Border (Gradient menggunakan brand-500 ke brand-300) --}}
                <div class="h-2 w-full bg-gradient-to-r from-brand-500 via-brand-300 to-brand-500"></div>

                <div class="flex flex-col lg:flex-row">
                    
                    {{-- ================= KOLOM KIRI: Visual Preview (Canvas) ================= --}}
                    {{-- Background kiri disesuaikan dengan brand-50 sesuai config --}}
                    <div class="w-full lg:w-[400px] bg-brand-50 dark:bg-brand-950/50 p-8 lg:p-10 border-r border-brand-100 dark:border-brand-800 flex flex-col items-center sticky top-0">
                        
                        <div class="relative w-full aspect-[210/297] max-w-[300px] mb-8 group flex flex-col items-center justify-center transition-transform hover:-translate-y-1 duration-500">
                            
                            @if($archive->files->count() > 0)
                                {{-- Canvas Container --}}
                                <div class="w-full h-full bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 document-shadow overflow-hidden relative">
                                    
                                    {{-- Loading State --}}
                                    <div id="pdf-loading" class="absolute inset-0 flex items-center justify-center bg-brand-50 dark:bg-brand-900 z-10">
                                        <svg class="animate-spin h-8 w-8 text-brand-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>

                                    {{-- The Actual Canvas --}}
                                    <canvas id="the-canvas" 
                                            class="w-full h-full object-cover"
                                            data-url="{{ asset('storage/' . $archive->files->first()->archive_path) }}"></canvas>
                                </div>
                            @else
                                {{-- Fallback --}}
                                <div class="w-full h-full bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 document-shadow flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 mb-2 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span class="text-sm">No Preview</span>
                                </div>
                            @endif

                        </div>

                        <div class="w-full max-w-[300px] space-y-3">
                            @if ($archive->files->count() > 0)
                                @php $mainFile = $archive->files->first(); @endphp
                                <a href="{{ route('archive.show_file', $mainFile->id) }}" 
                                   class="group w-full flex items-center justify-center gap-3 bg-brand-500 hover:bg-brand-600 text-white px-6 py-4 rounded-xl font-semibold shadow-lg shadow-brand-500/20 hover:shadow-brand-500/40 hover:-translate-y-0.5 transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <div class="text-left leading-tight">
                                        <span class="block">Lihat Detail Arsip</span>
                                    </div>
                                </a>
                            @else
                                <button disabled class="w-full flex items-center justify-center gap-2 bg-brand-100 text-brand-400 px-6 py-4 rounded-xl font-semibold cursor-not-allowed">
                                    File Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- ================= KOLOM KANAN: Detail & Metadata ================= --}}
                    <div class="flex-1 p-8 lg:p-12">
                        <div class="mb-10 border-b border-brand-100 dark:border-brand-800 pb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="px-3 py-1 rounded-md bg-brand-50 dark:bg-brand-900/50 text-brand-700 dark:text-brand-200 text-xs font-bold uppercase tracking-widest border border-brand-200 dark:border-brand-700">
                                    Arsip Publik
                                </span>
                                <span class="text-brand-200 dark:text-brand-700">|</span>
                                <span class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $archive->created_at->format('d F Y') }}
                                </span>
                            </div>

                            <h1 class="text-3xl lg:text-5xl font-bold font-['Playfair_Display'] text-brand-900 dark:text-brand-50 leading-tight mb-4">
                                {{ $archive->title }}
                            </h1>
                        </div>

                        <div class="space-y-8">
                            <div class="bg-white dark:bg-brand-25 rounded-2xl border border-brand-200 dark:border-brand-700 p-1">
                                <div class="bg-brand-50/50 dark:bg-brand-950/30 rounded-xl p-6 sm:p-8">
                                    <h3 class="flex items-center gap-2 text-lg font-bold text-brand-800 dark:text-brand-100 mb-6">
                                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Detail Informasi
                                    </h3>
                                    
                                    {{-- Wrapper ini memastikan text di dalamnya mengikuti tema --}}
                                    <div class="prose prose-sm prose-gray dark:prose-invert max-w-none 
                                        prose-strong:text-brand-900 dark:prose-strong:text-brand-50 
                                        prose-a:text-brand-600 dark:prose-a:text-brand-400">
                                        
                                        <x-archive-details :archive="$archive" />
                                    </div>
                                </div>
                            </div>

                            @if ($archive->files->count() > 1)
                                <div>
                                    <h3 class="text-sm font-bold uppercase tracking-wider text-brand-400 mb-4">Lampiran Tambahan</h3>
                                    <div class="grid gap-3">
                                        @foreach ($archive->files->skip(1) as $file)
                                            <a href="{{ route('archive.show_file', $file->id) }}" class="flex items-center justify-between p-4 bg-white dark:bg-brand-900 border border-brand-200 dark:border-brand-700 rounded-lg hover:border-brand-500 hover:ring-1 hover:ring-brand-500 transition-all group">
                                                <div class="flex items-center gap-3">
                                                    {{-- Icon PDF merah agar kontras --}}
                                                    <svg class="w-8 h-8 text-red-600/80" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-4H8l4-4 4 4h-3v4h-2z"/></svg>
                                                    <p class="font-medium text-gray-900 dark:text-white text-sm group-hover:text-brand-700 dark:group-hover:text-brand-300 transition-colors">
                                                        {{ $file->original_filename ?? basename($file->archive_path) }}
                                                    </p>
                                                </div>
                                                <svg class="w-5 h-5 text-brand-300 group-hover:text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer />

    {{-- SCRIPT: Render PDF Page 1 to Canvas --}}
    @if($archive->files->count() > 0)
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const canvas = document.getElementById('the-canvas');
            const url = canvas.getAttribute('data-url');
            const loadingIndicator = document.getElementById('pdf-loading');

            pdfjsLib.getDocument(url).promise.then(function(pdf) {
                // Fetch page 1
                pdf.getPage(1).then(function(page) {
                    const scale = 1.5; 
                    const viewport = page.getViewport({ scale: scale });

                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: canvas.getContext('2d'),
                        viewport: viewport
                    };
                    
                    const renderTask = page.render(renderContext);
                    
                    renderTask.promise.then(function() {
                        if(loadingIndicator) loadingIndicator.style.display = 'none';
                    });
                });
            }).catch(function(error) {
                console.error('Error loading PDF:', error);
                if(loadingIndicator) {
                    loadingIndicator.innerHTML = '<span class="text-xs text-red-500">Error preview</span>';
                }
            });
        });
    </script>
    @endif
</body>
</html>