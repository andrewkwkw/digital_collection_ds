<nav x-data="{ mobileMenuOpen: false }" 
     class="sticky top-0 z-50 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-brand-100 dark:border-gray-800 transition-colors duration-300">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 gap-4 lg:gap-8">

            {{-- ================= LEFT: Logo ================= --}}
            <div class="flex items-center gap-8 shrink-0">
                <a href="{{ route('welcome') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('storage/assets/Unpak.png') }}" alt="Logo Unpak" 
                         class="h-8 md:h-10 w-auto group-hover:scale-105 transition-transform duration-300 ease-in-out" />
                    <div class="flex flex-col">
                        <span class="text-[8px] md:text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest leading-none mb-0.5">
                            Universitas Pakuan
                        </span>
                        <span class="text-lg md:text-xl font-bold text-brand-600 dark:text-brand-200 leading-tight tracking-tight">
                            Digital Collection
                        </span>
                    </div>
                </a>

                {{-- DESKTOP NAVIGATION (Hidden on Mobile) --}}
                <div class="hidden lg:flex items-center gap-1 text-sm font-medium text-gray-600 dark:text-gray-300">
                    <a href="{{ route('welcome') }}" 
                       class="px-4 py-2 rounded-full transition-all duration-200 hover:bg-brand-50 hover:text-brand-700 dark:hover:bg-gray-800 dark:hover:text-brand-200">
                        Beranda
                    </a>
                    <a href="{{ route('jelajah') }}" 
                       class="px-4 py-2 rounded-full transition-all duration-200 hover:bg-brand-50 hover:text-brand-700 dark:hover:bg-gray-800 dark:hover:text-brand-200">
                        Jelajahi
                    </a>
                    
                    {{-- Dropdown Tentang Kami (Desktop) --}}
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = ! open" class="inline-flex items-center gap-1 px-4 py-2 rounded-full transition-all duration-200 hover:bg-brand-50 hover:text-brand-700 dark:hover:bg-gray-800 dark:hover:text-brand-200">
                            <span>Tentang Kami</span>
                            <svg class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
                             class="absolute left-0 z-50 mt-2 w-48 rounded-xl shadow-xl shadow-brand-500/10 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 overflow-hidden" style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('about') }}" class="block px-4 py-2.5 text-sm hover:bg-brand-50 dark:hover:bg-gray-700">Profil</a>
                                <a href="{{ route('team') }}" class="block px-4 py-2.5 text-sm hover:bg-brand-50 dark:hover:bg-gray-700">Tim Kami</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= CENTER: Search Bar (Desktop Only) ================= --}}
            <form method="GET" action="{{ route('jelajah') }}" class="hidden lg:flex items-center flex-1 max-w-lg mx-4">
                <div class="relative w-full group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 group-focus-within:text-brand-500">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
                    </div>
                    <div class="flex shadow-sm rounded-full bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 focus-within:ring-2 focus-within:ring-brand-500 overflow-hidden hover:border-brand-200">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari arsip digital..." class="w-full border-none bg-transparent py-2.5 pl-10 pr-4 text-sm text-gray-900 dark:text-white focus:ring-0 placeholder-gray-400">
                        <div class="h-6 w-px bg-gray-300 dark:bg-gray-600 my-auto"></div>
                        <select name="filter" class="border-none bg-transparent py-2.5 pl-4 pr-8 text-sm text-gray-600 dark:text-gray-300 focus:ring-0 cursor-pointer hover:text-brand-600 bg-none">
                            <option value="">Semua</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" {{ request('filter') === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="ml-2 p-2.5 bg-brand-500 text-white rounded-full hover:bg-brand-600 shadow-lg shadow-brand-500/30">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
                </button>
            </form>

            {{-- ================= RIGHT: Actions & Mobile Triggers ================= --}}
            <div class="flex items-center gap-3">
                
                {{-- Theme Toggle (Always Visible) --}}
                <x-theme-toggle />

                {{-- Desktop Login Button --}}
                <div class="hidden lg:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-brand-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-brand-600 text-white text-sm font-semibold rounded-full shadow-lg shadow-brand-500/30 hover:bg-brand-700 hover:-translate-y-0.5 transition-all">Login</a>
                    @endauth
                </div>

                {{-- MOBILE ACTIONS (Visible < lg) --}}
                <div class="flex lg:hidden items-center gap-2">
                    
                    {{-- 1. Mobile Search Icon Button --}}
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors">
                        <span class="sr-only">Search</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    {{-- 2. Hamburger Button --}}
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors focus:outline-none">
                        <span class="sr-only">Open menu</span>
                        {{-- Icon Hamburger --}}
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        {{-- Icon Close (X) --}}
                        <svg x-show="mobileMenuOpen" style="display: none;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= MOBILE MENU (Slide Down) ================= --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden absolute top-20 left-0 w-full bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 shadow-xl"
         style="display: none;">
        
        <div class="px-4 pt-4 pb-6 space-y-4">
            
            {{-- Mobile Search Form (Full Width) --}}
            <form method="GET" action="{{ route('jelajah') }}" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari arsip..." 
                       class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl py-3 pl-10 pr-4 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 dark:text-white">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </form>

            {{-- Mobile Links --}}
            <div class="space-y-1">
                <a href="{{ route('welcome') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-brand-50 dark:hover:bg-gray-800 hover:text-brand-600">Beranda</a>
                <a href="{{ route('jelajah') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-brand-50 dark:hover:bg-gray-800 hover:text-brand-600">Jelajahi</a>
                
                {{-- Dropdown Toggle Mobile --}}
                <div x-data="{ subOpen: false }">
                    <button @click="subOpen = !subOpen" class="flex items-center justify-between w-full px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-brand-50 dark:hover:bg-gray-800 hover:text-brand-600">
                        <span>Tentang Kami</span>
                        <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': subOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="subOpen" class="pl-6 mt-1 space-y-1">
                        <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 dark:text-gray-400 hover:text-brand-600">Profil</a>
                        <a href="{{ route('team') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 dark:text-gray-400 hover:text-brand-600">Tim Kami</a>
                    </div>
                </div>
            </div>

            {{-- Mobile Login Button --}}
            <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                @auth
                    <a href="{{ url('/dashboard') }}" class="block w-full text-center px-4 py-3 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 rounded-xl bg-brand-600 text-white font-semibold shadow-lg shadow-brand-500/30">Login Masuk</a>
                @endauth
            </div>
        </div>
    </div>
</nav>