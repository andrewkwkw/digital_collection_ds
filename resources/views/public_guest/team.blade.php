<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Tim Kami') }} - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|playfair-display:400,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Tailwind CSS fallback */
            @layer theme {}
        </style>
    @endif

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia(
            '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body
    class="bg-gray-50 dark:bg-brand-25 antialiased font-['Instrument_Sans'] text-gray-900 dark:text-gray-100 flex flex-col min-h-screen">

    <x-nav-guest />

    <main class="flex-grow">
        
        {{-- ================= HERO SECTION ================= --}}
        <div class="relative bg-brand-900 pt-20 pb-32 text-center overflow-hidden shadow-2xl shadow-brand-900/20 isolate">
             {{-- Abstract Background Elements --}}
             <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-brand-500 opacity-20 blur-3xl mix-blend-screen"></div>
             <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-brand-400 opacity-10 blur-3xl mix-blend-screen"></div>
             
             {{-- Pattern Overlay (Subtle) --}}
             <div class="absolute inset-0 opacity-[0.03] bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

            <div class="relative z-10 max-w-4xl mx-auto px-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-6">
                    <span class="w-2 h-2 rounded-full bg-brand-300"></span>
                    <span class="text-xs font-bold uppercase tracking-widest text-brand-100">Meet The Team</span>
                </div>
                
                <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white tracking-tight font-['Playfair_Display']">
                    Siapa Kami
                </h1>
                <p class="text-lg md:text-xl text-brand-100/80 max-w-2xl mx-auto font-light leading-relaxed">
                    Mengenal lebih dekat para visioner dan profesional di balik pelestarian arsip Digital Collection Universitas Pakuan.
                </p>
            </div>
        </div>

        {{-- ================= TEAM GRID SECTION ================= --}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 -mt-20 pb-24 relative z-20">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                @foreach ($team as $member)
                    <a href="{{ route('team.show', $member->id) }}" class="block group h-full">
                        <div class="relative h-full bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-xl shadow-gray-200/50 dark:shadow-none transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-brand-900/10">
                            
                            {{-- Badge Logo (Glassmorphism) --}}
                            <div class="absolute top-4 right-4 z-30 flex items-center gap-2 bg-white/30 dark:bg-black/30 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/20 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                <img src="{{ asset('storage/assets/Unpak.png') }}" alt="Logo" class="h-4 w-auto">
                                <span class="text-[10px] font-bold text-white uppercase tracking-widest">FISIB</span>
                            </div>

                            <div class="relative aspect-[3/4] overflow-hidden">
                                @if ($member->photo_path)
                                    {{-- Image: Grayscale to Color on Hover --}}
                                    <img src="{{ asset('storage/' . $member->photo_path) }}" alt="{{ $member->name }}"
                                        class="w-full h-full object-cover object-top transition duration-700 ease-out group-hover:scale-105 filter grayscale group-hover:grayscale-0">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-400">
                                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Gradient Overlay (Bottom Fade) --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-brand-900 via-brand-900/40 to-transparent opacity-90 transition-opacity duration-300"></div>
                            </div>

                            <div class="absolute bottom-0 inset-x-0 p-6 z-30">
                                {{-- Decorative Batik Pattern (Subtle Background for Text) --}}
                                <div class="absolute bottom-0 right-0 w-32 h-32 bg-contain bg-no-repeat bg-bottom opacity-10 pointer-events-none mix-blend-overlay"
                                     style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Ornamen_Batik_Keraton_Yogyakarta.svg/1024px-Ornamen_Batik_Keraton_Yogyakarta.svg.png'); filter: invert(1);">
                                </div>

                                {{-- Text Content --}}
                                <div class="relative transform transition-transform duration-300 group-hover:-translate-y-1">
                                    <h3 class="text-2xl font-bold text-white font-['Playfair_Display'] tracking-wide leading-tight mb-1">
                                        {{ $member->name }}
                                    </h3>
                                    <div class="w-16 h-1 bg-brand-400 mb-3 rounded-full"></div>
                                    <p class="text-xs font-bold text-brand-200 uppercase tracking-[0.2em]">
                                        {{ $member->position }}
                                    </p>
                                </div>
                            </div>

                            {{-- Active Border Effect on Hover --}}
                            <div class="absolute inset-0 border-2 border-transparent group-hover:border-brand-300/30 rounded-3xl pointer-events-none transition-colors duration-300"></div>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </main>

    <x-footer />
</body>

</html>