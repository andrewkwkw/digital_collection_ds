<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $file->original_filename ?? 'Dokumen Arsip' }} - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    {{-- Load Vite --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    {{-- Custom Scrollbar & Cursor Logic --}}
    <style>
        /* Mengatur cursor saat mode panning */
        #pdf-container {
            cursor: grab;
            cursor: -webkit-grab;
        }
        #pdf-container.grabbing {
            cursor: grabbing;
            cursor: -webkit-grabbing;
        }

        /* Scrollbar kustom agar menyatu dengan background gelap (Brand 950) */
        #pdf-container::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }
        #pdf-container::-webkit-scrollbar-track {
            background: #151f15; /* Sesuai brand-950 */
        }
        #pdf-container::-webkit-scrollbar-thumb {
            background-color: #324a32; /* Sesuai brand-800 */
            border-radius: 6px;
            border: 3px solid #151f15;
        }
        #pdf-container::-webkit-scrollbar-thumb:hover {
            background-color: #4d744d; /* Sesuai brand-600 */
        }
    </style>
</head>

{{-- Layout Flex Column Full Height --}}
<body class="bg-brand-950 font-['Instrument_Sans'] h-screen flex flex-col overflow-hidden text-gray-100">

    <header class="bg-brand-900 border-b border-brand-800 shadow-md z-30 shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <div class="flex items-center gap-4 overflow-hidden">
                @php
                    $backRoute = (request('from') === 'admin' && auth()->check()) 
                        ? route('admin.archive.show', $file->archive_id) 
                        : route('archive.show-guest', $file->archive_id);
                @endphp

                <a href="{{ $backRoute }}" 
                   class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-800 hover:bg-brand-700 text-brand-200 transition-colors"
                   title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </a>

                <div class="flex flex-col">
                    <h1 class="text-white font-semibold text-sm sm:text-base truncate max-w-[200px] sm:max-w-md">
                        {{ $file->original_filename ?? basename($file->archive_path) }}
                    </h1>
                    <span class="text-xs text-brand-300">Mode Pratinjau</span>
                </div>
            </div>

            <div>
                <a href="{{ route('file.download.watermark', $file->id) }}"
                   class="flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-lg shadow-brand-900/50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    <span class="hidden sm:inline">Download</span>
                </a>
            </div>
        </div>
    </header>

    <div class="bg-brand-800/80 backdrop-blur-sm border-b border-brand-700 z-20 shrink-0">
        <div class="max-w-7xl mx-auto px-4 h-12 flex items-center justify-center relative">
            
            <div class="flex items-center bg-brand-900 rounded-md border border-brand-700 p-1 shadow-sm">
                <button onclick="zoomOut()" class="p-1.5 text-brand-200 hover:text-white hover:bg-brand-700 rounded transition" title="Zoom Out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                </button>
                
                <span id="page-info" class="mx-3 text-xs font-mono text-brand-200 w-24 text-center">Loading...</span>
                
                <button onclick="zoomIn()" class="p-1.5 text-brand-200 hover:text-white hover:bg-brand-700 rounded transition" title="Zoom In">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </button>
            </div>

            <div class="hidden sm:block absolute right-4 text-xs text-brand-400">
                <span class="flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"></path></svg>
                    Klik & Geser untuk Scroll
                </span>
            </div>
        </div>
    </div>

    <div id="pdf-container" class="flex-1 relative overflow-auto bg-brand-25 p-4 sm:p-8 flex justify-center items-start">
        
        <div id="pdf-pages" class="flex flex-col gap-6 transition-transform duration-200 ease-out origin-top pb-20">
            {{-- Loading State (Akan hilang setelah JS jalan) --}}
            <div class="flex flex-col items-center justify-center mt-20 text-brand-400 animate-pulse">
                <svg class="w-10 h-10 mb-3 animate-spin text-brand-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <p>Memuat Dokumen...</p>
            </div>
        </div>

    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        // --- 1. CONFIGURATION ---
        const url = "{{ asset('storage/' . $file->archive_path) }}";
        const container = document.getElementById('pdf-pages');
        const pageInfo = document.getElementById('page-info');
        
        let pdfDoc = null;
        let scale = 1.0; // Default zoom level
        let isRendering = false;

        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        // --- 2. INITIALIZATION ---
        pdfjsLib.getDocument(url).promise.then(pdf => {
            pdfDoc = pdf;
            updatePageInfo();
            renderAllPages();
        }).catch(err => {
            container.innerHTML = `
                <div class="text-red-400 bg-red-900/20 border border-red-800 p-4 rounded-lg text-center">
                    <p class="font-bold">Gagal memuat PDF</p>
                    <p class="text-sm mt-1">${err.message}</p>
                </div>`;
        });

        // --- 3. RENDER LOGIC ---
        function renderAllPages() {
            container.innerHTML = ''; // Clear previous render

            for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                pdfDoc.getPage(pageNum).then(page => {
                    const viewport = page.getViewport({ scale });

                    // Create Wrapper (Paper Effect)
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative shadow-2xl shadow-black/60 bg-white'; // White paper background
                    
                    // Create Canvas
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;
                    canvas.className = 'block select-none'; // Prevent selection

                    wrapper.appendChild(canvas);
                    container.appendChild(wrapper);

                    // Render
                    const renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };
                    page.render(renderContext);
                });
            }
        }

        function updatePageInfo() {
            if(pdfDoc) {
                const percent = Math.round(scale * 100);
                pageInfo.textContent = `${pdfDoc.numPages} Hal (${percent}%)`;
            }
        }

        // --- 4. ZOOM CONTROLS ---
        function zoomIn() {
            if (scale >= 3.0) return;
            scale += 0.2;
            updatePageInfo();
            renderAllPages();
        }

        function zoomOut() {
            if (scale <= 0.4) return;
            scale -= 0.2;
            updatePageInfo();
            renderAllPages();
        }

        // --- 5. PANNING LOGIC (Drag to Scroll) ---
        const pdfContainer = document.getElementById('pdf-container');
        let isPanning = false, startX, startY, scrollLeft, scrollTop;

        pdfContainer.addEventListener('mousedown', (e) => {
            if (e.button !== 0) return; // Only Left Click
            isPanning = true;
            pdfContainer.classList.add('grabbing');
            startX = e.pageX;
            startY = e.pageY;
            scrollLeft = pdfContainer.scrollLeft;
            scrollTop = pdfContainer.scrollTop;
        });

        window.addEventListener('mouseup', () => {
            isPanning = false;
            pdfContainer.classList.remove('grabbing');
        });

        window.addEventListener('mousemove', (e) => {
            if (!isPanning) return;
            e.preventDefault();
            const dx = e.pageX - startX;
            const dy = e.pageY - startY;
            pdfContainer.scrollLeft = scrollLeft - dx;
            pdfContainer.scrollTop = scrollTop - dy;
        });
    </script>
</body>
</html>