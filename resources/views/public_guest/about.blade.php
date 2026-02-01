<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

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
            /* Fallback jika build belum jalan */
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

<body class="bg-gray-50 dark:bg-brand-25 antialiased font-['Instrument_Sans'] text-gray-800 dark:text-gray-200 flex flex-col min-h-screen selection:bg-brand-200 selection:text-brand-900">

    <x-nav-guest />

    <main class="flex-grow">
        
        {{-- ================= HERO SECTION (Mewah & Minimalis) ================= --}}
        <div class="relative bg-brand-900 text-white pt-24 pb-32 md:pt-32 md:pb-40 overflow-hidden isolate">
            
            {{-- Decorative Blobs --}}
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-brand-500 opacity-20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-brand-400 opacity-10 blur-3xl"></div>
            
            {{-- Content --}}
            <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-6">
                    <span class="w-2 h-2 rounded-full bg-brand-300"></span>
                    <span class="text-xs font-bold uppercase tracking-widest text-brand-100">Tentang Kami</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-bold tracking-tight mb-6 leading-tight">
                    Melestarikan Pengetahuan <br>
                    <span class="text-brand-200 italic font-serif">Untuk Masa Depan</span>
                </h1>
                
                <p class="text-lg md:text-xl text-brand-100/80 max-w-2xl mx-auto font-light leading-relaxed">
                    Digital Collection Universitas Pakuan adalah jembatan antara sejarah masa lalu 
                    dan inovasi masa depan melalui arsip digital yang terintegrasi.
                </p>
            </div>
        </div>

        {{-- ================= MISI & VISUAL SECTION ================= --}}
        <div class="relative -mt-20 z-20 max-w-7xl mx-auto px-6 lg:px-8 pb-24">
            
            {{-- Card Putih Besar (Container Utama) --}}
            <div class="bg-white dark:bg-brand-25 rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-gray-200/50 dark:shadow-none border border-brand-400 dark:border-brand-600">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                    
                    {{-- Kiri: Teks Misi --}}
                    <div class="order-2 lg:order-1">
                        <h2 class="text-brand-600 dark:text-brand-400 font-bold uppercase tracking-widest text-sm mb-3">
                            Misi & Dedikasi
                        </h2>
                        <h3 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6 leading-snug">
                            Membangun Ekosistem <br> Akademik Digital
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-8 text-lg font-light">
                            Kami hadir sebagai wadah penyimpanan aset digital yang bernilai sejarah dan akademis. 
                            Komitmen kami bukan sekadar menyimpan, tetapi <span class="font-medium text-brand-700 dark:text-brand-300">menghidupkan kembali</span> informasi agar mudah diakses oleh civitas akademika dan masyarakat luas.
                        </p>

                        <div class="space-y-6">
                            {{-- Item List dengan Icon Mewah --}}
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-brand-50 dark:bg-brand-900/50 flex items-center justify-center text-brand-600 dark:text-brand-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-gray-900 dark:text-white font-bold text-lg">Digitalisasi Presisi</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Mengubah dokumen fisik menjadi format digital berkualitas tinggi.</p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-brand-50 dark:bg-brand-900/50 flex items-center justify-center text-brand-600 dark:text-brand-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-gray-900 dark:text-white font-bold text-lg">Aksesibilitas Tanpa Batas</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Memudahkan peneliti menemukan referensi dalam hitungan detik.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kanan: Gambar Artistik --}}
                    <div class="order-1 lg:order-2 relative">
                        {{-- Background Accent --}}
                        <div class="absolute inset-0 bg-brand-200 dark:bg-brand-800 rounded-[2rem] transform rotate-6 scale-95 translate-x-4"></div>
                        
                        {{-- Main Image --}}
                        <div class="relative rounded-[2rem] overflow-hidden shadow-xl aspect-[4/5] lg:aspect-square group">
                            <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=2256&auto=format&fit=crop" 
                                 alt="Library Archive" 
                                 class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105" />
                            
                            {{-- Glass Overlay Content --}}
                            <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/80 to-transparent">
                                <p class="text-white/90 font-serif italic text-lg">"Arsip adalah memori kolektif yang tak ternilai."</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ================= STATS SECTION (Modern Clean) ================= --}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 pb-24">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- Stat 1 --}}
                <div class="group p-8 rounded-3xl bg-white dark:bg-brand-25 border border-gray-100 dark:border-gray-800 hover:border-brand-200 dark:hover:border-brand-700 hover:shadow-xl hover:shadow-brand-900/5 transition-all duration-300">
                    <div class="text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-brand-700 to-brand-500 mb-4 font-serif">
                        01
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Pencarian Cepat</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm">
                        Algoritma pencarian yang dioptimalkan untuk menemukan dokumen spesifik secara instan.
                    </p>
                </div>

                {{-- Stat 2 --}}
                <div class="group p-8 rounded-3xl bg-brand-900 text-white shadow-2xl shadow-brand-900/20 transform md:-translate-y-4">
                    <div class="text-5xl font-bold text-brand-200 mb-4 font-serif">
                        02
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Kualitas HD</h3>
                    <p class="text-brand-100/80 leading-relaxed text-sm">
                        Setiap arsip dipindai dengan resolusi tinggi untuk menjaga detail dan keaslian dokumen.
                    </p>
                </div>

                {{-- Stat 3 --}}
                <div class="group p-8 rounded-3xl bg-white dark:bg-brand-25 border border-gray-100 dark:border-gray-800 hover:border-brand-200 dark:hover:border-brand-700 hover:shadow-xl hover:shadow-brand-900/5 transition-all duration-300">
                    <div class="text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-brand-700 to-brand-500 mb-4 font-serif">
                        03
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Terstruktur</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm">
                        Taksonomi kategori yang rapi memudahkan navigasi antar jenis koleksi arsip.
                    </p>
                </div>

            </div>
        </div>

    </main>

    <x-footer />
</body>

</html>