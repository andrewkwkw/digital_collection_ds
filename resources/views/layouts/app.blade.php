<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Fonts: Instrument Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="icon" href="{{ asset('storage/assets/Unpak.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
        }

        /* Optional: Animasi lambat untuk blob agar terasa hidup */
        @keyframes blob-float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(-20px, 20px) scale(1.05);
            }
        }

        .animate-blob-slow {
            animation: blob-float 20s infinite ease-in-out;
        }
    </style>
</head>

<body
    class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-brand-25 selection:bg-brand-500/30 selection:text-brand-700 dark:selection:text-brand-300 overflow-x-hidden">

    {{--
    =========================================
    NEW BACKGROUND: Simple Large Blob Top Right
    =========================================
    --}}
    <div class="fixed inset-0 -z-10 h-full w-full overflow-hidden pointer-events-none">
        {{-- Base background color transition --}}
        <div class="absolute inset-0 bg-gray-50 dark:bg-brand-25 transition-colors duration-500"></div>

        {{-- Blob Light Mode (Biru/Brand muda) --}}
        <div
            class="absolute -top-[30%] -right-[10%] w-[80%] h-[80%] rounded-full bg-brand-200/60 mix-blend-multiply blur-[120px] opacity-70 dark:hidden animate-blob-slow">
        </div>

        {{-- Blob Dark Mode (Brand gelap, lebih subtle) --}}
        <div
            class="absolute -top-[30%] -right-[10%] w-[80%] h-[80%] rounded-full bg-brand-200/60 mix-blend-soft-light blur-[130px] opacity-50 hidden dark:block animate-blob-slow">
        </div>
    </div>

    <div class="min-h-screen flex flex-col relative">

        {{-- Navigation --}}
        <nav
            class="sticky top-0 z-50 w-full backdrop-blur-xl bg-white/80 dark:bg-gray-900/80 border-b border-white/20 dark:border-gray-800/50 supports-[backdrop-filter]:bg-white/60 dark:supports-[backdrop-filter]:bg-gray-900/60">
            @include('layouts.navigation')
        </nav>

        {{-- Page Header --}}
        @isset($header)
            <header class="relative pt-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{--
                    PERBAIKAN:
                    Menggunakan 'w-full' dan menghapus wrapper flex/h1 bawaan layout
                    agar komponen header dari dashboard bisa leluasa mengatur posisinya (mentok kanan).
                    --}}
                    <div class="pb-4 w-full">
                        {{ $header }}
                    </div>

                    {{-- Garis dekorasi --}}
                    <div class="h-0.5 w-full bg-brand-600 dark:bg-brand-400 rounded-full"></div>
                </div>
            </header>
        @endisset

        {{-- Main Content --}}
        <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="animate-in fade-in slide-in-from-bottom-4 duration-700 ease-out">
                {{ $slot }}
            </div>
        </main>

        {{-- Footer --}}
        <footer class="py-6 text-center text-xs text-gray-400 dark:text-gray-600 z-10">
            &copy; {{ date('Y') }} {{ config('app.name') }}.
        </footer>
    </div>
</body>

</html>