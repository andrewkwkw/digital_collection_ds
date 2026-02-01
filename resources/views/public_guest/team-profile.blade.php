<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $member->name }} - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|playfair-display:400,600,700" rel="stylesheet" />

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

<body class="bg-gray-50 dark:bg-gray-950 antialiased font-['Instrument_Sans'] text-gray-900 dark:text-gray-100 flex flex-col min-h-screen relative selection:bg-brand-200 selection:text-brand-900">

    <x-nav-guest />

    {{-- Background Blobs (Decoration) --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-300/20 rounded-full blur-3xl mix-blend-multiply dark:mix-blend-overlay"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-brand-300/20 rounded-full blur-3xl mix-blend-multiply dark:mix-blend-overlay"></div>
    </div>

    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-8">
                <a href="{{ route('team') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-brand-600 text-white rounded-full font-semibold hover:bg-brand-700 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-brand-600/30 transition-all duration-300 text-sm">
                    Kembali ke Tim
                </a>
            </div>

            <div class="bg-white dark:bg-brand-25 rounded-[2.5rem] shadow-2xl shadow-gray-200/50 dark:shadow-none overflow-hidden min-h-[600px] ring-1 ring-gray-100 dark:ring-gray-800">
                <div class="flex flex-col lg:flex-row h-full">
                    
                    {{-- ================= LEFT: Photo Section ================= --}}
                    <div class="w-full lg:w-[480px] relative flex-shrink-0 bg-gray-100 dark:bg-gray-800">
                        
                        <div class="absolute top-6 left-6 z-30 flex items-center gap-2 bg-white/30 backdrop-blur-md border border-white/20 px-4 py-1.5 rounded-full shadow-lg">
                            <img src="{{ asset('storage/assets/Unpak.png') }}" alt="Logo" class="h-6 w-auto">
                            <span class="text-xs font-bold text-white uppercase tracking-widest">FISIB</span>
                        </div>

                        <div class="h-[500px] lg:h-full relative z-0 group">
                            @if ($member->photo_path)
                                <img src="{{ asset('storage/' . $member->photo_path) }}" alt="{{ $member->name }}" 
                                     class="w-full h-full object-cover object-top filter grayscale lg:grayscale-0 transition-all duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-400">
                                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                </div>
                            @endif
                            
                            {{-- Gradient Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-brand-900 via-transparent to-transparent opacity-90 lg:opacity-80"></div>
                            
                            {{-- Pattern Overlay --}}
                            <div class="absolute inset-0 opacity-[0.15] mix-blend-overlay bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                        </div>
                        
                        <div class="absolute bottom-0 inset-x-0 p-8 lg:p-10 z-20 text-white">
                            {{-- Ornamental Pattern --}}
                             <div class="absolute bottom-0 right-0 w-40 h-40 bg-contain bg-no-repeat bg-bottom opacity-10 pointer-events-none mix-blend-screen"
                                 style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Ornamen_Batik_Keraton_Yogyakarta.svg/1024px-Ornamen_Batik_Keraton_Yogyakarta.svg.png'); filter: invert(1);">
                            </div>

                            <div class="relative">
                                <h1 class="text-3xl lg:text-4xl font-bold font-['Playfair_Display'] leading-tight mb-2 text-shadow">
                                    {{ $member->name }}
                                </h1>
                                <div class="w-16 h-1 bg-brand-400 mb-4 rounded-full shadow-[0_0_10px_rgba(74,222,128,0.5)]"></div>
                                <p class="text-brand-200 uppercase tracking-widest text-sm font-semibold">
                                    {{ $member->position }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- ================= RIGHT: Details Section ================= --}}
                    <div class="flex-1 p-8 lg:p-12 lg:pl-16 flex flex-col justify-center">
                        <div class="max-w-3xl">
                            
                            <div class="flex items-center gap-3 mb-8">
                                <span class="text-sm font-bold text-brand-600 dark:text-brand-400 uppercase tracking-widest">Informasi Akademik</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12 mb-10">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Pendidikan Terakhir</p>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $member->education ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">NIDN</p>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white font-mono">{{ $member->nidn ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">NIP</p>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white font-mono">{{ $member->nip ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Email</p>
                                    <a href="mailto:{{ $member->email }}" class="text-lg font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300 hover:underline decoration-brand-300 underline-offset-4 transition-colors">
                                        {{ $member->email ?? '-' }}
                                    </a>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-6 mb-10 border border-gray-100 dark:border-gray-700/50">
                                <div class="grid gap-6">
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Bidang Keahlian</p>
                                        <p class="text-gray-800 dark:text-gray-200 leading-relaxed">
                                            {{ $member->expertise ?? '-' }}
                                        </p>
                                    </div>
                                    <div class="h-px w-full bg-gray-200 dark:bg-gray-700"></div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Fokus Riset</p>
                                        <p class="text-gray-800 dark:text-gray-200 leading-relaxed">
                                            {{ $member->research_focus ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-10">
                                <p class="text-sm font-bold text-gray-900 dark:text-white mb-4">Profil Peneliti</p>
                                <div class="flex flex-wrap gap-3">
                                    @php
                                        $ids = [
                                            ['label' => 'Sinta ID', 'val' => $member->sinta_id],
                                            ['label' => 'Scholar ID', 'val' => $member->scholar_id],
                                            ['label' => 'Scopus ID', 'val' => $member->scopus_id],
                                            ['label' => 'Orcid', 'val' => $member->orcid_id],
                                        ];
                                    @endphp

                                    @foreach($ids as $id)
                                        @if($id['val'])
                                            <div class="inline-flex items-center px-4 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm text-sm">
                                                <span class="text-gray-500 dark:text-gray-400 mr-2">{{ $id['label'] }}:</span>
                                                <span class="font-mono font-medium text-gray-900 dark:text-gray-200 select-all">{{ $id['val'] }}</span>
                                            </div>
                                        @endif
                                    @endforeach

                                    @if(empty(array_filter(array_column($ids, 'val'))))
                                        <span class="text-gray-400 italic text-sm">Tidak ada ID eksternal terhubung.</span>
                                    @endif
                                </div>
                            </div>

                            <div class="pt-6 border-t border-gray-100 dark:border-gray-800">
                                @if ($member->cv_path)
                                    <a href="{{ asset('storage/' . $member->cv_path) }}" target="_blank" 
                                       class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-brand-600 text-white rounded-full font-semibold hover:bg-brand-700 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-brand-600/30 transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Unduh Curriculum Vitae
                                    </a>
                                @else
                                    <button disabled class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gray-100 dark:bg-gray-800 text-gray-400 rounded-full font-semibold cursor-not-allowed">
                                        CV Tidak Tersedia
                                    </button>
                                @endif
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
            text-shadow: 0 4px 12px rgba(0,0,0,0.5);
        }
    </style>
</body>
</html>