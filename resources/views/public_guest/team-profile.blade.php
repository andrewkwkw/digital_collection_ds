<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $member->name }} - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
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

<body class="bg-gray-50 dark:bg-gray-900 antialiased font-['Instrument_Sans'] text-gray-900 dark:text-gray-100 flex flex-col min-h-screen">

    <x-nav-guest />

    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <!-- Breadcrumb -->
            <div class="mb-8 pl-4">
                <a href="{{ route('team') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Tim
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden min-h-[600px]">
                <div class="flex flex-col md:flex-row h-full">
                    
                    <!-- Left: Photo Card (Similar to Grid) -->
                    <div class="w-full md:w-[450px] bg-blue-900 relative flex-shrink-0 border-r-4 border-white dark:border-gray-700">
                        <!-- Patterns -->
                        <div class="absolute top-0 left-0 w-24 h-24 bg-no-repeat bg-contain z-10 opacity-70"
                             style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Ornamen_Batik_Keraton_Yogyakarta.svg/1024px-Ornamen_Batik_Keraton_Yogyakarta.svg.png'); filter: invert(1);"></div>
                        <div class="absolute bottom-0 right-0 w-32 h-32 bg-no-repeat bg-contain z-10 opacity-50 transform rotate-180"
                             style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Ornamen_Batik_Keraton_Yogyakarta.svg/1024px-Ornamen_Batik_Keraton_Yogyakarta.svg.png'); filter: invert(1);"></div>

                        <!-- Logo -->
                        <div class="absolute top-6 left-6 z-20 flex items-center gap-2 bg-white/95 px-4 py-1.5 rounded-full shadow-lg">
                            <img src="{{ asset('storage/assets/Unpak.png') }}" alt="Logo" class="h-8 w-auto">
                            <span class="text-sm font-bold text-blue-900 uppercase tracking-widest">FISIB</span>
                        </div>

                        <!-- Photo -->
                        <div class="h-[500px] md:h-full relative z-0 mt-20 md:mt-0">
                            @if ($member->photo_path)
                                <img src="{{ asset('storage/' . $member->photo_path) }}" alt="{{ $member->name }}" 
                                     class="w-full h-full object-cover object-top mask-image-gradient">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">
                                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Nameplate Overlay -->
                         <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-blue-900 to-transparent pt-20 pb-8 text-center text-white z-20">
                             <h1 class="text-3xl font-bold uppercase tracking-wide text-shadow">{{ $member->name }}</h1>
                         </div>
                    </div>

                    <!-- Right: Details -->
                    <div class="flex-1 p-8 md:p-12">
                        <div class="max-w-3xl">
                            <!-- Header Info -->
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-8">
                                <h2 class="text-4xl font-light text-gray-900 dark:text-gray-100 mb-2">{{ $member->name }}</h2>
                                <p class="text-xl text-blue-600 dark:text-blue-400 font-medium">{{ $member->position }}</p>
                            </div>

                            <!-- Details List -->
                            <div class="space-y-4 text-base md:text-lg text-gray-700 dark:text-gray-300">
                                <div class="flex flex-col md:flex-row gap-2 md:gap-8">
                                    <div class="w-64 font-semibold text-gray-500 dark:text-gray-400">Pendidikan Terakhir</div>
                                    <div>: {{ $member->education ?? '-' }}</div>
                                </div>
                                
                                <div class="flex flex-col md:flex-row gap-2 md:gap-8">
                                    <div class="w-64 font-semibold text-gray-500 dark:text-gray-400">NIDN</div>
                                    <div>: {{ $member->nidn ?? '-' }}</div>
                                </div>

                                <div class="flex flex-col md:flex-row gap-2 md:gap-8">
                                    <div class="w-64 font-semibold text-gray-500 dark:text-gray-400">NIP</div>
                                    <div>: {{ $member->nip ?? '-' }}</div>
                                </div>

                                <!-- External IDs -->
                                <div class="flex flex-col md:flex-row gap-2 md:gap-8">
                                    <div class="w-64 font-semibold text-gray-500 dark:text-gray-400">Sinta ID</div>
                                    <div>: {{ $member->sinta_id ?? '-' }}</div>
                                </div>
                                <div class="flex flex-col md:flex-row gap-2 md:gap-8">
                                    <div class="w-64 font-semibold text-gray-500 dark:text-gray-400">Scholar ID</div>
                                    <div>: {{ $member->scholar_id ?? '-' }}</div>
                                </div>
                                <div class="flex flex-col md:flex-row gap-2 md:gap-8">
                                    <div class="w-64 font-semibold text-gray-500 dark:text-gray-400">Scopus ID</div>
                                    <div>: {{ $member->scopus_id ?? '-' }}</div>
                                </div>
                                <div class="flex flex-col md:flex-row gap-2 md:gap-8">
                                    <div class="w-64 font-semibold text-gray-500 dark:text-gray-400">Orcid</div>
                                    <div>: {{ $member->orcid_id ?? '-' }}</div>
                                </div>

                                <div class="pt-4 border-t border-gray-100 dark:border-gray-800 mt-4"></div>

                                <div class="flex flex-col md:flex-row gap-2 md:gap-8">
                                    <div class="w-64 font-semibold text-gray-500 dark:text-gray-400">Bidang Keahlian</div>
                                    <div>: {{ $member->expertise ?? '-' }}</div>
                                </div>

                                <div class="flex flex-col md:flex-row gap-2 md:gap-8">
                                    <div class="w-64 font-semibold text-gray-500 dark:text-gray-400">Fokus Riset</div>
                                    <div>: {{ $member->research_focus ?? '-' }}</div>
                                </div>
                                
                                <div class="flex flex-col md:flex-row gap-2 md:gap-8">
                                    <div class="w-64 font-semibold text-gray-500 dark:text-gray-400">Email</div>
                                    <div>: <a href="mailto:{{ $member->email }}" class="text-blue-600 hover:underline">{{ $member->email ?? '-' }}</a></div>
                                </div>

                                <!-- CV Download -->
                                <div class="flex flex-col md:flex-row gap-2 md:gap-8 items-center mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <div class="w-64 font-semibold text-gray-500 dark:text-gray-400">CV</div>
                                    <div>
                                        @if ($member->cv_path)
                                            <a href="{{ asset('storage/' . $member->cv_path) }}" target="_blank" 
                                               class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Unduh CV
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">Tidak tersedia</span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <x-footer />
    
    <style>
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
    </style>
</body>
</html>
