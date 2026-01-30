<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
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

    <!-- Dark Mode Initialization -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-white dark:bg-gray-900 antialiased font-['Instrument_Sans']">
    <!-- Navigation -->
    <x-nav-guest />

    <!-- Main Content -->
    <main class="min-h-screen">
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('welcome') }}"
                        class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        {{ __('Kembali ke Beranda') }}
                    </a>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6 text-white">
                        <h1 class="text-3xl font-bold mb-2">{{ $archive->title }}</h1>
                        <p class="text-blue-100">{{ __('Diunggah pada') }}
                            {{ $archive->created_at->format('d F Y, H:i') }}
                        </p>
                    </div>

                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- Files Section -->
                        @if ($archive->files->count() > 0)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">{{ __('File PDF') }}
                                </h3>
                                <div class="space-y-3">
                                    @foreach ($archive->files as $file)
                                        <div
                                            class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition">
                                            <div class="flex-shrink-0">
                                                <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 12c0 .55.45 1 1 1h15.59L8.29 4.71c-.39-.39-.39-1.02 0-1.41.39-.39 1.02-.39 1.41 0l10.59 10.59c.39.39.39 1.02 0 1.41l-10.59 10.59c-.39.39-1.02.39-1.41 0-.39-.39-.39-1.02 0-1.41L17.59 13H2c-.55 0-1 .45-1 1z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-900 dark:text-white mb-1">
                                                    {{ $file->original_filename ?? basename($file->archive_path) }}
                                                </p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">PDF Document</p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('archive.show_file', $file->id) }}"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ __('Lihat') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div
                                class="mb-8 p-6 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                                <p class="text-yellow-800 dark:text-yellow-200">
                                    {{ __('Tidak ada file yang tersedia untuk arsip ini.') }}
                                </p>
                            </div>
                        @endif

                        <!-- Metadata Component -->
                        <x-archive-details :archive="$archive" />
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    <x-footer />
</body>

</html>