<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <style>
            /* Smooth transitions untuk switch dark mode */
            body {
                transition: background-color 0.3s ease, color 0.3s ease;
            }
        </style>
    </head>
    <body class="font-sans antialiased selection:bg-brand-500/30">
        <div class="fixed inset-0 -z-10 h-full w-full bg-white dark:bg-[#0f172a] transition-colors duration-500">
            <div class="absolute bottom-0 left-0 right-0 top-0 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:14px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>
        </div>

        <div class="min-h-screen">
            <nav class="sticky top-0 z-40 w-full backdrop-blur-md bg-white/80 dark:bg-gray-900/80 border-b border-gray-200 dark:border-gray-800">
                @include('layouts.navigation')
            </nav>

            @isset($header)
                <header class="relative overflow-hidden">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between">
                            <div class="space-y-1">
                                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $header }}
                                </h1>
                                <div class="h-1 w-20 bg-brand-500 rounded-full"></div>
                            </div>
                            
                            </div>
                    </div>
                </header>
            @endisset

            <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="animate-in fade-in slide-in-from-bottom-4 duration-700">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>