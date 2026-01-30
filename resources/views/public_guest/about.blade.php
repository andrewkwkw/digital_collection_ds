<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Tentang Kami') }} - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Tailwind CSS fallback */
            @layer theme {}
        </style>
    @endif

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body
    class="bg-white dark:bg-gray-900 antialiased font-['Instrument_Sans'] text-gray-900 dark:text-gray-100 flex flex-col min-h-screen">

    <x-nav-guest />

    <main class="flex-grow">
        <!-- Hero Section -->
        <div class="bg-blue-600 py-16 text-white text-center rounded-b-[3rem] shadow-lg mb-12 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>

            <div class="relative z-10 max-w-4xl mx-auto px-6">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Tentang Digital Collection</h1>
                <p class="text-lg text-blue-100 max-w-2xl mx-auto">
                    Platform arsip digital Universitas Pakuan untuk melestarikan dan menyebarluaskan pengetahuan.
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 pb-16">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Misi Kami</h2>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                        Digital Collection Universitas Pakuan hadir sebagai wadah penyimpanan aset digital yang bernilai
                        sejarah dan akademis.
                        Kami berkomitmen untuk mendigitalisasi, mengelola, dan memberikan akses terbuka terhadap koleksi
                        arsip, jurnal,
                        skripsi, dan dokumen penting lainnya bagi civitas akademika dan masyarakat luas.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-200">Melestarikan dokumen fisik ke dalam format
                                digital.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-200">Memudahkan akses informasi bagi peneliti dan
                                mahasiswa.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-200">Mendukung keterbukaan informasi
                                publik.</span>
                        </li>
                    </ul>
                </div>
                <div class="relative">
                    <div class="absolute -inset-4 bg-blue-100 dark:bg-blue-900/30 rounded-2xl transform rotate-3 z-0">
                    </div>
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
                        alt="Library Archive" class="relative z-10 rounded-xl shadow-xl w-full h-auto object-cover" />
                </div>
            </div>

            <!-- Stats or Features -->
            <div
                class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 mb-16">
                <div
                    class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-gray-200 dark:divide-gray-700">
                    <div class="p-4">
                        <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">Akses Cepat</div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pencarian dokumen dalam hitungan detik.</p>
                    </div>
                    <div class="p-4">
                        <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">Format Digital</div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Arsip tersedia dalam format PDF dan Gambar
                            berkualitas.</p>
                    </div>
                    <div class="p-4">
                        <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">Terorganisir</div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pengelolaan data yang rapi dan mudah
                            ditelusuri.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer />
</body>

</html>