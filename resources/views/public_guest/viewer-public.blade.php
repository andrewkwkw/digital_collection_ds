<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $file->original_filename ?? basename($file->archive_path) }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Tailwind CSS (auto-generated fallback) */
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            @layer theme {}
        </style>
    @endif
</head>

<body class="bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('archive.show-guest', $file->archive_id) }}"
   class="text-white hover:text-gray-300 flex items-center gap-2">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 19l-7-7 7-7" />
    </svg>
    <span>Kembali</span>
</a>

                <h1 class="text-white font-semibold truncate max-w-xs">
                    {{ $file->original_filename ?? basename($file->archive_path) }}
                </h1>
            </div>
        </div>
    </nav>

    <!-- Toolbar -->
    <div class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-3 text-white">
                <div class="flex gap-2 items-center">
                    <button onclick="zoomOut()" class="px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </button>
                    <button onclick="zoomIn()" class="px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <span id="page-info" class="ml-4 text-sm text-gray-300"></span>
                </div>

                <a href="{{ route('file.download.watermark', $file->id) }}"
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    {{ __('Download') }}
                </a>
            </div>
        </div>
    </div>

    <!-- PDF Viewer Container -->
    <div id="pdf-container" class="bg-gray-900 min-h-[calc(100vh-8rem)] overflow-y-auto"
        style="height: calc(100vh - 8rem);">
        <div id="pdf-pages" class="flex flex-col items-center py-6 gap-6"></div>
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
            pageInfo.textContent = `{{ __('Total') }} ${pdf.numPages} {{ __('halaman') }}`;
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
</body>

</html>