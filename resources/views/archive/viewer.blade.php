<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
    {{ $file->original_filename ?? basename($file->archive_path) }}
</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="mb-3">
                <a href="{{ url()->previous() }}"
                class="text-blue-600 hover:underline">&larr; Kembali</a>
            </div>

            <!-- Toolbar -->
            <div class="flex items-center justify-between px-4 py-2 bg-gray-800 text-white rounded-t-lg">
    <div class="flex gap-2 items-center">
        <button onclick="zoomOut()" class="px-3 py-1 bg-gray-700 rounded hover:bg-gray-600">−</button>
        <button onclick="zoomIn()" class="px-3 py-1 bg-gray-700 rounded hover:bg-gray-600">+</button>
        <span id="page-info" class="ml-4 text-sm"></span>
    </div>
    
    <div class="flex items-center gap-4">
        <div class="text-sm truncate max-w-xs hidden md:block">
            {{ $file->original_filename }}
        </div>
        
        <a href="{{ asset('storage/' . $file->archive_path) }}" 
           download="{{ $file->original_filename }}" 
           class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded text-sm transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Download
        </a>
    </div>
</div>

            <!-- PDF Viewer -->
            <div id="pdf-container"
                 class="bg-gray-300 border border-gray-300 rounded-b-lg overflow-y-auto"
                 style="height: 80vh;">
                <div id="pdf-pages" class="flex flex-col items-center py-6 gap-6"></div>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        const url = "{{ asset('storage/' . $file->archive_path) }}";

        let pdfDoc = null;
        let scale = 1.2;
        const container = document.getElementById('pdf-pages');
        const pageInfo = document.getElementById('page-info');

        pdfjsLib.GlobalWorkerOptions.workerSrc =
            'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        pdfjsLib.getDocument(url).promise.then(pdf => {
            pdfDoc = pdf;
            pageInfo.textContent = `Total ${pdf.numPages} halaman`;
            renderAllPages();
        });

        function renderAllPages() {
            container.innerHTML = '';

            for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                pdfDoc.getPage(pageNum).then(page => {
                    const viewport = page.getViewport({ scale });

                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    canvas.width = viewport.width;
                    canvas.height = viewport.height;
                    canvas.className = 'shadow-lg bg-white';

                    const wrapper = document.createElement('div');
                    wrapper.className = 'bg-white p-2 rounded';
                    wrapper.appendChild(canvas);

                    container.appendChild(wrapper);

                    page.render({
                        canvasContext: ctx,
                        viewport: viewport
                    });
                });
            }
        }

        function zoomIn() {
            scale += 0.15;
            renderAllPages();
        }

        function zoomOut() {
            if (scale <= 0.6) return;
            scale -= 0.15;
            renderAllPages();
        }
    </script>
    <script>
    const pdfContainer = document.getElementById('pdf-container');

    let isPanning = false;
    let startX = 0;
    let startY = 0;
    let scrollLeft = 0;
    let scrollTop = 0;

    pdfContainer.addEventListener('mousedown', (e) => {
        // Jangan trigger saat klik kanan
        if (e.button !== 0) return;

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
<style>
    #pdf-container {
        cursor: grab;
    }
    #pdf-container.grabbing {
        cursor: grabbing;
        user-select: none;
    }
</style>
</x-app-layout>
