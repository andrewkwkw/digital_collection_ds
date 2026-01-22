<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white leading-tight truncate">
                {{ $file->original_filename ?? basename($file->archive_path) }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col items-center">
        <div class="w-full max-w-6xl px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('archive.show_file', $file->id) }}" class="group flex items-center text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-2 group-hover:bg-blue-50 group-hover:border-blue-200 transition-all">
                        &larr;
                    </div>
                    Kembali ke Detail
                </a>

                <div class="hidden sm:block px-3 py-1 bg-gray-200 dark:bg-gray-800 rounded-full">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500">PDF Viewer</span>
                </div>
            </div>

            <div id="main-viewer-wrapper" class="relative flex flex-col bg-white dark:bg-gray-800 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.5)] rounded-xl overflow-hidden ring-4 ring-gray-300 dark:ring-gray-700 transition-all duration-300">
                
                <div class="flex items-center justify-between px-4 py-3 bg-gray-800 text-white border-b border-gray-700 z-20">
                    
                    <div class="flex items-center gap-2">
                        <div class="flex bg-gray-700 rounded p-0.5 border border-gray-600">
                            <button onclick="zoomOut()" class="w-8 h-8 flex items-center justify-center hover:bg-gray-600 rounded text-gray-300 hover:text-white text-lg font-bold" title="Zoom Out">−</button>
                            <span class="w-px bg-gray-600 my-1"></span>
                            <button onclick="zoomIn()" class="w-8 h-8 flex items-center justify-center hover:bg-gray-600 rounded text-gray-300 hover:text-white text-lg font-bold" title="Zoom In">+</button>
                        </div>
                        <span id="page-count" class="ml-2 text-xs font-mono text-gray-400 bg-gray-900 px-2 py-1 rounded border border-gray-700 min-w-[80px] text-center">Loading...</span>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <button onclick="toggleFullscreen()" class="flex items-center gap-2 px-3 py-1.5 bg-gray-700 hover:bg-gray-600 text-gray-200 rounded text-xs font-bold uppercase tracking-wider border border-gray-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                            <span id="fullscreen-text" class="hidden sm:inline">Fullscreen</span>
                        </button>
                        
                        <a href="{{ asset('storage/' . $file->archive_path) }}" download="{{ $file->original_filename }}" class="flex items-center gap-2 px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded text-xs font-bold uppercase tracking-wider shadow-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            <span class="hidden sm:inline">Download</span>
                        </a>
                    </div>
                </div>

                <div id="pdf-scroll-container" class="relative overflow-y-auto bg-gray-200 dark:bg-gray-900 scroll-smooth" style="height: 75vh;">
                    <div id="pdf-wrapper" class="flex flex-col items-center py-8 px-4 gap-6 min-h-full">
                        </div>
                </div>

                <div id="viewer-footer" class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 px-4 py-2 flex justify-between items-center text-[10px] uppercase font-bold text-gray-400 tracking-wider">
                    <span class="truncate max-w-xs">{{ $file->original_filename }}</span>
                    <span>Secure Viewer Mode</span>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        const url = "{{ asset('storage/' . $file->archive_path) }}";
        const container = document.getElementById('pdf-wrapper');
        const scrollContainer = document.getElementById('pdf-scroll-container');
        const pageCountLabel = document.getElementById('page-count');
        const viewerWrapper = document.getElementById('main-viewer-wrapper');
        const footer = document.getElementById('viewer-footer');
        
        let pdfDoc = null;
        let scale = 1.0; 

        // Load PDF
        pdfjsLib.getDocument(url).promise.then(pdf => {
            pdfDoc = pdf;
            pageCountLabel.textContent = `${pdf.numPages} Pages`;
            renderPages();
        }).catch(err => {
            container.innerHTML = `<div class="p-4 text-red-500">Error: ${err.message}</div>`;
        });

        function renderPages() {
            container.innerHTML = ''; 
            for (let num = 1; num <= pdfDoc.numPages; num++) {
                pdfDoc.getPage(num).then(page => {
                    const viewport = page.getViewport({ scale });
                    
                    // Wrapper untuk efek kertas (Putih + Shadow)
                    const pageDiv = document.createElement('div');
                    pageDiv.className = "relative bg-white shadow-xl mb-2 transition-transform";
                    pageDiv.style.width = `${viewport.width}px`;
                    pageDiv.style.height = `${viewport.height}px`;

                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    pageDiv.appendChild(canvas);
                    container.appendChild(pageDiv);

                    page.render({ canvasContext: ctx, viewport: viewport });
                });
            }
        }

        function zoomIn() { scale += 0.2; renderPages(); }
        function zoomOut() { if (scale <= 0.4) return; scale -= 0.2; renderPages(); }

        // Logic Fullscreen (Menghapus frame saat fullscreen)
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                viewerWrapper.requestFullscreen().catch(err => alert(err.message));
            } else {
                document.exitFullscreen();
            }
        }

        document.addEventListener('fullscreenchange', () => {
            if (document.fullscreenElement) {
                // Hapus border/radius saat fullscreen
                viewerWrapper.classList.remove('rounded-xl', 'ring-4', 'shadow-[0_20px_60px_-15px_rgba(0,0,0,0.5)]', 'max-w-6xl');
                viewerWrapper.classList.add('w-screen', 'h-screen');
                scrollContainer.style.height = 'calc(100vh - 58px)'; // Full height minus toolbar
                footer.style.display = 'none';
            } else {
                // Kembalikan style frame
                viewerWrapper.classList.add('rounded-xl', 'ring-4', 'shadow-[0_20px_60px_-15px_rgba(0,0,0,0.5)]');
                viewerWrapper.classList.remove('w-screen', 'h-screen');
                scrollContainer.style.height = '75vh';
                footer.style.display = 'flex';
            }
        });
    </script>
</x-app-layout>