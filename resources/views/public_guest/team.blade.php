<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Tim Kami') }} - {{ config('app.name') }}</title>
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
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia(
            '(prefers-color-scheme: dark)').matches)) {
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
        <div class="bg-blue-800 py-16 text-white text-center shadow-lg mb-12 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>

            <div class="relative z-10 max-w-4xl mx-auto px-6">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Siapa Kami</h1>
                <p class="text-lg text-blue-200 max-w-2xl mx-auto">
                    Mengenal lebih dekat tim di balik Digital Collection Universitas Pakuan.
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 pb-16">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($team as $member)
                    <!-- Team Member Card -->
                    <a href="{{ route('team.show', $member->id) }}" class="block group">
                        <div
                            class="bg-blue-900 rounded-lg overflow-hidden border-4 border-white shadow-xl relative transition transform group-hover:-translate-y-2 group-hover:shadow-2xl">
                            <!-- Ornamental Pattern (Top Corners) -->
                            <div class="absolute top-0 left-0 w-20 h-20 bg-no-repeat bg-contain z-20 pointer-events-none opacity-80"
                                style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Ornamen_Batik_Keraton_Yogyakarta.svg/1024px-Ornamen_Batik_Keraton_Yogyakarta.svg.png'); filter: invert(1);">
                            </div>
                            <div class="absolute top-0 right-0 w-20 h-20 bg-no-repeat bg-contain z-20 pointer-events-none opacity-80 transform scale-x-[-1]"
                                style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Ornamen_Batik_Keraton_Yogyakarta.svg/1024px-Ornamen_Batik_Keraton_Yogyakarta.svg.png'); filter: invert(1);">
                            </div>

                            <!-- Header with Logo -->
                            <div
                                class="absolute top-4 left-4 z-30 flex items-center gap-2 bg-white/90 px-3 py-1 rounded-full shadow">
                                <img src="{{ asset('storage/assets/Unpak.png') }}" alt="Logo" class="h-6 w-auto">
                                <span class="text-xs font-bold text-blue-900 uppercase tracking-widest">FISIB</span>
                            </div>

                            <!-- Image Container -->
                            <div class="relative h-96 overflow-hidden bg-gray-200">
                                @if ($member->photo_path)
                                    <img src="{{ asset('storage/' . $member->photo_path) }}" alt="{{ $member->name }}"
                                        class="w-full h-full object-cover object-top transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">
                                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Bottom Nameplate -->
                            <div
                                class="absolute bottom-0 inset-x-0 bg-blue-800 text-center py-4 border-t-4 border-white z-30">
                                <h3 class="text-xl font-bold text-white uppercase tracking-wide truncate px-4">
                                    {{ $member->name }}</h3>
                                <p class="text-xs text-blue-200 font-medium uppercase mt-1 tracking-wider truncate px-4">
                                    {{ $member->position }}</p>
                            </div>

                            <!-- Ornamental Pattern (Bottom Corners) -->
                            <div class="absolute bottom-16 left-0 w-24 h-24 bg-no-repeat bg-contain z-20 pointer-events-none opacity-60"
                                style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Ornamen_Batik_Keraton_Yogyakarta.svg/1024px-Ornamen_Batik_Keraton_Yogyakarta.svg.png'); filter: invert(1); transform: scaleY(-1);">
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </main>

    <x-footer />
</body>

</html>