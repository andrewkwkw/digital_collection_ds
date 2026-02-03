<x-app-layout>
    <x-slot name="head">
        {{-- PDF.js Library --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
        <script>
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
        </script>
        
        <style>
            /* Custom Scrollbar untuk Viewer */
            .pdf-scroll::-webkit-scrollbar {
                width: 10px;
                height: 10px;
            }
            .pdf-scroll::-webkit-scrollbar-track {
                background: #f1f1f1; 
            }
            .dark .pdf-scroll::-webkit-scrollbar-track {
                background: #1f2937; 
            }
            .pdf-scroll::-webkit-scrollbar-thumb {
                background: #cbd5e1; 
                border-radius: 5px;
            }
            .pdf-scroll::-webkit-scrollbar-thumb:hover {
                background: #94a3b8; 
            }

            /* Efek Kertas Realistis */
            .paper-shadow {
                box-shadow: 
                    0 1px 1px rgba(0,0,0,0.15), 
                    0 10px 0 -5px #eee, 
                    0 10px 1px -4px rgba(0,0,0,0.15), 
                    0 20px 0 -10px #eee, 
                    0 20px 1px -9px rgba(0,0,0,0.15);
            }
            .dark .paper-shadow {
                box-shadow: 
                    0 1px 1px rgba(0,0,0,0.5), 
                    0 10px 0 -5px #374151, 
                    0 10px 1px -4px rgba(0,0,0,0.5), 
                    0 20px 0 -10px #1f2937, 
                    0 20px 1px -9px rgba(0,0,0,0.5);
            }
        </style>
    </x-slot>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col font-['Instrument_Sans']">
        
        {{-- Header / Navigation Bar --}}
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                {{-- Back Button (ADMIN ROUTE) --}}
                <a href="{{ route('admin.archive.show', $file->archive_id) }}" 
                   class="group flex items-center gap-3 text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
                    <div class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs uppercase tracking-wider font-bold text-gray-400">Kembali ke Arsip</span>
                        <span class="font-bold">{{ $file->original_filename }}</span>
                    </div>
                </a>

                {{-- Admin Badge --}}
                <span class="px-3 py-1 bg-brand-500 text-white text-[10px] font-bold uppercase tracking-widest rounded-full shadow-lg shadow-brand-500/30">
                    Admin Viewer
                </span>
            </div>
        </div>

        {{-- Main Viewer Area --}}
        <div class="flex-1 px-4 sm:px-6 lg:px-8 pb-8 flex flex-col overflow-hidden">
            <div id="viewer-container" class="max-w-6xl mx-auto w-full h-full flex flex-col bg-gray-800 rounded-2xl shadow-2xl overflow-hidden ring-1 ring-white/10 relative transition-all duration-300">
                
                {{-- Toolbar --}}
                <div class="h-16 bg-gray-900 border-b border-gray-700 flex items-center justify-between px-4 sm:px-6 z-20 shrink-0">
                    
                    {{-- Left: Page Info --}}
                    <div class="flex items-center gap-4">
                        <div class="flex items-center text-gray-300 bg-gray-800 rounded-lg px-3 py-1.5 border border-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span id="page-count" class="text-xs font-mono font-bold">Loading...</span>
                        </div>
                    </div>

                    {{-- Center: Zoom Controls --}}
                    <div class="absolute left-1/2 transform -translate-x-1/2 flex items-center gap-1 bg-gray-800 rounded-lg p-1 border border-gray-700 shadow-lg">
                        <button onclick="zoomOut()" class="w-8 h-8 flex items-center justify-center rounded hover:bg-gray-700 text-gray-400 hover:text-white transition-colors" title="Zoom Out">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                        </button>
                        <span class="w-px h-4 bg-gray-700 mx-1"></span>
                        <button onclick="zoomIn()" class="w-8 h-8 flex items-center justify-center rounded hover:bg-gray-700 text-gray-400 hover:text-white transition-colors" title="Zoom In">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>

                    {{-- Right: Actions --}}
                    <div class="flex items-center gap-3">
                        <button onclick="toggleFullscreen()" class="p-2 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors" title="Fullscreen">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                        </button>
                        <div class="h-4 w-px bg-gray-700"></div>
                        <a href="{{ asset('storage/' . $file->archive_path) }}" download="{{ $file->original_filename }}" class="flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors shadow-lg shadow-brand-900/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            <span class="hidden sm:inline">Download</span>
                        </a>
                    </div>
                </div>

                {{-- Scrollable Canvas Area --}}
                <div id="pdf-scroll-container" class="flex-1 overflow-y-auto bg-gray-200/50 dark:bg-gray-900/50 relative pdf-scroll">
                    
                    {{-- Loading Indicator --}}
                    <div id="loading-indicator" class="absolute inset-0 flex items-center justify-center z-0">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="animate-spin h-8 w-8 text-brand-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-gray-500 text-xs font-bold uppercase tracking-widest">Memuat Dokumen...</span>
                        </div>
                    </div>

                    {{-- Pages Container --}}
                    <div id="pdf-wrapper" class="flex flex-col items-center py-12 px-4 gap-8 min-h-full relative z-10">
                        {{-- Canvas elements will be injected here --}}
                    </div>
                </div>

                {{-- Footer Info --}}
                <div id="viewer-footer" class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 px-4 py-2 flex justify-between items-center text-[10px] uppercase font-bold text-gray-400 tracking-wider shrink-0">
                    <span class="truncate max-w-[200px]">{{ $file->original_filename }}</span>
                    <span>Admin Mode • Read Only</span>
                </div>

            </div>
        </div>
    </div>

    {{-- Viewer Script Logic --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const url = "{{ asset('storage/' . $file->archive_path) }}";
            const container = document.getElementById('pdf-wrapper');
            const scrollContainer = document.getElementById('pdf-scroll-container');
            const pageCountLabel = document.getElementById('page-count');
            const loadingIndicator = document.getElementById('loading-indicator');
            const viewerContainer = document.getElementById('viewer-container');
            const footer = document.getElementById('viewer-footer');

            let pdfDoc = null;
            let scale = 1.2; // Default scale slightly larger
            let isRendering = false;

            // Load PDF
            pdfjsLib.getDocument(url).promise.then(pdf => {
                pdfDoc = pdf;
                pageCountLabel.textContent = `${pdf.numPages} HALAMAN`;
                loadingIndicator.style.display = 'none'; // Hide loader
                renderPages();
            }).catch(err => {
                loadingIndicator.innerHTML = `<span class="text-red-500 font-bold">Gagal memuat PDF: ${err.message}</span>`;
            });

            function renderPages() {
                container.innerHTML = '';
                
                for (let num = 1; num <= pdfDoc.numPages; num++) {
                    // Create Wrapper for shadow effect
                    const pageWrapper = document.createElement('div');
                    pageWrapper.className = "relative bg-white dark:bg-gray-800 transition-all duration-300 paper-shadow group";
                    
                    // Page Number Indicator (Hover)
                    const pageNum = document.createElement('div');
                    pageNum.className = "absolute -right-12 top-0 text-xs font-bold text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity hidden xl:block";
                    pageNum.textContent = `#${num}`;
                    pageWrapper.appendChild(pageNum);

                    container.appendChild(pageWrapper);

                    pdfDoc.getPage(num).then(page => {
                        const viewport = page.getViewport({ scale: scale });
                        
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        canvas.className = "block"; // Remove inline-block spacing

                        // Set wrapper dimensions to match canvas
                        pageWrapper.style.width = `${viewport.width}px`;
                        pageWrapper.style.height = `${viewport.height}px`;

                        pageWrapper.appendChild(canvas);

                        const renderContext = {
                            canvasContext: ctx,
                            viewport: viewport
                        };
                        
                        page.render(renderContext);
                    });
                }
            }

            // Expose functions globally for buttons
            window.zoomIn = function() {
                scale += 0.2;
                renderPages();
            }

            window.zoomOut = function() {
                if (scale <= 0.6) return;
                scale -= 0.2;
                renderPages();
            }

            window.toggleFullscreen = function() {
                if (!document.fullscreenElement) {
                    viewerContainer.requestFullscreen().catch(err => {
                        console.error(`Error attempting to enable fullscreen: ${err.message}`);
                    });
                } else {
                    document.exitFullscreen();
                }
            }

            // Handle Fullscreen UI changes
            document.addEventListener('fullscreenchange', () => {
                if (document.fullscreenElement) {
                    viewerContainer.classList.remove('rounded-2xl', 'max-w-6xl', 'ring-1', 'shadow-2xl');
                    viewerContainer.classList.add('w-screen', 'h-screen');
                    // Hide header/footer if needed, or adjust padding
                    document.body.style.overflow = 'hidden'; // Prevent body scroll
                    footer.style.display = 'none';
                } else {
                    viewerContainer.classList.add('rounded-2xl', 'max-w-6xl', 'ring-1', 'shadow-2xl');
                    viewerContainer.classList.remove('w-screen', 'h-screen');
                    document.body.style.overflow = ''; // Restore body scroll
                    footer.style.display = 'flex';
                }
            });
        });
    </script>
</x-app-layout>