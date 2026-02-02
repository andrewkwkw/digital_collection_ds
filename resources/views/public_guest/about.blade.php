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

<body
    class="bg-gray-50 dark:bg-brand-25 antialiased font-['Instrument_Sans'] text-gray-800 dark:text-gray-200 flex flex-col min-h-screen selection:bg-brand-200 selection:text-brand-900">

    <x-nav-guest />

    <main class="flex-grow">

        {{-- ================= HERO SECTION ================= --}}
        <div class="relative bg-brand-900 text-white pt-24 pb-32 md:pt-32 md:pb-40 overflow-hidden isolate">
            {{-- Decorative Blobs --}}
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-brand-500 opacity-20 blur-3xl">
            </div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-brand-400 opacity-10 blur-3xl">
            </div>

            {{-- Content --}}
            <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-6">
                    <span class="w-2 h-2 rounded-full bg-brand-300"></span>
                    <span class="text-xs font-bold uppercase tracking-widest text-brand-100">Tentang Kami</span>
                </div>

                <h1 class="text-4xl md:text-6xl font-bold tracking-tight mb-6 leading-tight">
                    Profil Lab Digitalisasi Sastra <br>
                    <span class="text-brand-200 italic font-serif">FISIB Universitas Pakuan</span>
                </h1>

                <p class="text-lg md:text-xl text-brand-100/90 max-w-4xl mx-auto font-light leading-relaxed">
                    Lab Digitalisasi Sastra merupakan unit di bawah naungan Fakultas Ilmu Sosial dan Ilmu Budaya (FISIB)
                    Universitas Pakuan yang berfokus pada preservasi dan penyebarluasan warisan budaya. Kami
                    menghadirkan Digital Collection, sebuah platform inovatif yang mengintegrasikan teknologi digital
                    dengan kekayaan literatur nusantara.
                </p>
            </div>
        </div>

        {{-- ================= VISION & MISSION SECTION ================= --}}
        <div class="relative -mt-20 z-20 max-w-7xl mx-auto px-6 lg:px-8 pb-24">
            <div
                class="bg-white dark:bg-brand-900 rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-gray-200/50 dark:shadow-none border border-brand-100 dark:border-brand-800">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

                    {{-- Text Content --}}
                    <div class="order-2 lg:order-1">
                        <h2 class="text-brand-600 dark:text-brand-400 font-bold uppercase tracking-widest text-sm mb-3">
                            Visi & Misi
                        </h2>
                        <h3 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6 leading-snug">
                            Pusat Rujukan <br> Pengetahuan Lokal
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6 text-lg font-light">
                            Menjadi pusat rujukan pengetahuan lokal melalui pengelolaan arsip dan naskah kuno yang
                            kredibel, khususnya dalam bidang sastra dan sejarah di wilayah Bogor, Jawa Barat.
                        </p>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-lg font-light">
                            Kami berkomitmen untuk mentransformasikan dokumen fisik yang bernilai sejarah tinggi ke
                            dalam format digital agar dapat diakses secara inklusif oleh masyarakat luas.
                        </p>
                    </div>

                    {{-- Image --}}
                    <div class="order-1 lg:order-2 relative">
                        <div
                            class="absolute inset-0 bg-brand-200 dark:bg-brand-800 rounded-[2rem] transform rotate-3 scale-95 translate-x-2">
                        </div>
                        <div class="relative rounded-[2rem] overflow-hidden shadow-xl aspect-[4/3] group">
                            <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=2370&auto=format&fit=crop"
                                alt="Vision Mission"
                                class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= SERVICES SECTION ================= --}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 pb-24">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Layanan & Platform</h2>
                <p class="text-gray-600 dark:text-gray-400 text-lg">
                    Platform Digital Collection kami berfungsi sebagai perpustakaan digital interaktif yang menyimpan
                    berbagai koleksi penting.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Service 1 --}}
                <div
                    class="group p-8 rounded-3xl bg-white dark:bg-brand-900/50 border border-gray-100 dark:border-brand-800 hover:border-brand-200 dark:hover:border-brand-700 hover:shadow-xl hover:shadow-brand-900/5 transition-all duration-300 hover:-translate-y-2">
                    <div
                        class="w-14 h-14 rounded-2xl bg-brand-50 dark:bg-brand-800 flex items-center justify-center text-brand-600 dark:text-brand-300 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3
                        class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">
                        Arsip Sejarah</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                        Dokumentasi peristiwa dan perkembangan wilayah lokal yang menjadi saksi bisu perjalanan waktu.
                    </p>
                </div>

                {{-- Service 2 --}}
                <div
                    class="group p-8 rounded-3xl bg-brand-900 text-white shadow-2xl shadow-brand-900/20 transform md:-translate-y-4 transition-transform duration-300 hover:-translate-y-2 md:hover:-translate-y-6">
                    <div
                        class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-brand-200 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Naskah Kuno</h3>
                    <p class="text-brand-100/80 leading-relaxed">
                        Digitalisasi teks-teks klasik yang menyimpan kearifan lokal, melestarikannya untuk generasi
                        mendatang.
                    </p>
                </div>

                {{-- Service 3 --}}
                <div
                    class="group p-8 rounded-3xl bg-white dark:bg-brand-900/50 border border-gray-100 dark:border-brand-800 hover:border-brand-200 dark:hover:border-brand-700 hover:shadow-xl hover:shadow-brand-900/5 transition-all duration-300 hover:-translate-y-2">
                    <div
                        class="w-14 h-14 rounded-2xl bg-brand-50 dark:bg-brand-800 flex items-center justify-center text-brand-600 dark:text-brand-300 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </path>
                        </svg>
                    </div>
                    <h3
                        class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">
                        Pengetahuan Lokal</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                        Ruang edukasi bagi peneliti, mahasiswa, dan masyarakat umum yang ingin mendalami sejarah.
                    </p>
                </div>
            </div>
        </div>

        {{-- ================= PARTNERS SECTION ================= --}}
        <div class="bg-gray-50 dark:bg-brand-950 py-24">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-12">Kolaborasi Strategis</h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-12">
                    Kami percaya bahwa pelestarian budaya adalah tanggung jawab kolektif. Hingga saat ini, Lab
                    Digitalisasi Sastra telah bekerja sama dengan berbagai lembaga kredibel.
                </p>

                <div
                    class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-70 grayscale transition-all duration-500 hover:grayscale-0 hover:opacity-100">
                    {{-- Partner 1 --}}
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 bg-gray-200 dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <span class="font-bold text-gray-500">1</span>
                        </div>
                        <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Bogor Eksperimen</span>
                    </div>

                    {{-- Partner 2 --}}
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 bg-gray-200 dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <span class="font-bold text-gray-500">2</span>
                        </div>
                        <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Komunitas Bogor
                            Historia</span>
                    </div>

                    {{-- Partner 3 --}}
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 bg-gray-200 dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <span class="font-bold text-gray-500">3</span>
                        </div>
                        <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Yayasan Al Irsyad Al
                            Islamiyyah</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= CTA / INVITATION SECTION ================= --}}
        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-24">
            <div
                class="relative overflow-hidden bg-brand-600 dark:bg-brand-900 rounded-[2.5rem] px-6 py-16 sm:px-16 sm:py-24 shadow-2xl">
                {{-- Background Pattern --}}
                <svg viewBox="0 0 1024 1024"
                    class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2 -translate-y-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]"
                    aria-hidden="true">
                    <circle cx="512" cy="512" r="512" fill="url(#gradient)" fill-opacity="0.3" />
                    <defs>
                        <radialGradient id="gradient">
                            <stop stop-color="#ffffff" />
                            <stop offset="1" stop-color="#ffffff" />
                        </radialGradient>
                    </defs>
                </svg>

                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white mb-6">
                        Undangan Kerja Sama
                    </h2>
                    <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-brand-100">
                        Sebagai wujud tanggung jawab akademik dan sosial, kami membuka pintu kolaborasi bagi Komunitas,
                        Kementerian, serta Lembaga Pemerintah maupun Swasta dalam program digitalisasi naskah dan
                        pengembangan konten sejarah.
                    </p>
                    <div class="mt-10 flex items-center justify-center">
                        <a href="mailto:lab.sastra@unpak.ac.id"
                            class="rounded-full bg-white px-8 py-3.5 text-sm font-bold text-brand-600 shadow-sm hover:bg-brand-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                            Hubungi Kami
                        </a>
                    </div>
                    <p class="mt-12 text-sm text-brand-200 font-serif italic">
                        "Mari bersama menjaga jejak literasi bangsa untuk generasi masa depan."
                    </p>
                </div>
            </div>
        </div>

    </main>

    <x-footer />
</body>

</html>