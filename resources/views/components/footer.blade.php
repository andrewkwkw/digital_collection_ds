<footer class="relative bg-brand-50 dark:bg-gray-900 mt-auto">
    {{-- Decorative Top Line --}}
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-200 via-brand-500 to-brand-200 opacity-50"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            
            {{-- Brand / Info --}}
            <div class="col-span-1 space-y-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('storage/assets/Unpak.png') }}" alt="Logo Unpak"
                        class="h-10 w-auto" />
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-none">Universitas Pakuan</span>
                        <span class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">
                            Digital Collection
                        </span>
                    </div>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed max-w-xs">
                    Platform arsip digital untuk referensi akademik dan umum.
                    Menyimpan, merawat, dan mempublikasikan koleksi digital intelektual Universitas Pakuan.
                </p>
                
                {{-- Flag Counter styled nicely --}}
                <div class="inline-block overflow-hidden rounded-lg shadow-sm opacity-70 hover:opacity-100 transition-opacity duration-300 border border-brand-100 dark:border-gray-700">
                    <a href="https://info.flagcounter.com/vE4V">
                        <img src="https://s01.flagcounter.com/count/vE4V/bg_FFFFFF/txt_000000/border_CCCCCC/columns_2/maxflags_12/viewers_0/labels_0/pageviews_0/flags_0/percent_0/"
                            alt="Flag Counter" border="0" class="block">
                    </a>
                </div>
            </div>

            {{-- Links --}}
            <div class="col-span-1 md:col-start-2">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest mb-6 border-b border-brand-200 dark:border-gray-700 pb-2 inline-block">
                    Menu Utama
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('welcome') }}"
                            class="group flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-200 dark:bg-gray-600 mr-2 group-hover:bg-brand-500 transition-colors"></span>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('jelajah') }}"
                            class="group flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-200 dark:bg-gray-600 mr-2 group-hover:bg-brand-500 transition-colors"></span>
                            Jelajahi Koleksi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}"
                            class="group flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-200 dark:bg-gray-600 mr-2 group-hover:bg-brand-500 transition-colors"></span>
                            Tentang Kami
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ url('/dashboard') }}"
                                class="group flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-200 dark:bg-gray-600 mr-2 group-hover:bg-brand-500 transition-colors"></span>
                                Dashboard
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}"
                                class="group flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-200 dark:bg-gray-600 mr-2 group-hover:bg-brand-500 transition-colors"></span>
                                Login Admin
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            {{-- Contact / Extra --}}
            <div class="col-span-1">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest mb-6 border-b border-brand-200 dark:border-gray-700 pb-2 inline-block">
                    Hubungi Kami
                </h3>
                <ul class="space-y-4 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex items-start gap-3">
                        <div class="mt-1 p-1.5 bg-brand-100 dark:bg-gray-800 rounded-full text-brand-600 dark:text-brand-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="leading-relaxed">Perpustakaan Universitas Pakuan,<br>Jl. Pakuan, Tegallega, Bogor Tengah 16143</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="p-1.5 bg-brand-100 dark:bg-gray-800 rounded-full text-brand-600 dark:text-brand-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="font-medium hover:text-brand-600 transition-colors cursor-pointer">library@unpak.ac.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-brand-200 dark:border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm text-gray-500 dark:text-gray-500">
                &copy; {{ date('Y') }} <span class="font-semibold text-brand-700 dark:text-brand-400">{{ config('app.name') }}</span>. All rights reserved.
            </p>
            <div class="flex items-center gap-4">
                {{-- Social Icons --}}
                <a href="#" class="text-gray-400 hover:text-brand-600 dark:hover:text-brand-400 transition-transform hover:-translate-y-1 duration-200">
                    <span class="sr-only">GitHub</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>