<nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 gap-6">

            {{-- LEFT --}}
            <div class="flex items-center gap-6">
                <a href="{{ route('welcome') }}" class="flex items-center gap-3">
                    <img src="{{ asset('storage/assets/Unpak.png') }}" alt="Logo Unpak" class="h-10 w-auto" />
                    <div class="flex flex-col">
                        <span
                            class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide leading-none">
                            Universitas Pakuan
                        </span>
                        <span class="text-lg font-bold text-blue-600 dark:text-blue-400 leading-tight">
                            Digital Collection
                        </span>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-700 dark:text-gray-300">
                    <a href="{{ route('welcome') }}" class="hover:text-blue-600 transition">
                        Home
                    </a>
                    <a href="{{ route('jelajah') }}" class="hover:text-blue-600 transition">
                        Jelajahi
                    </a>
                    {{-- DROPDOWN TENTANG KAMI --}}
                    <div class="relative" x-data="{ open: false }" @click.away="open = false"
                        @close.stop="open = false">
                        <button @click="open = ! open"
                            class="inline-flex items-center gap-1 hover:text-blue-600 transition {{ request()->routeIs('about') || request()->routeIs('team') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                            <span>Tentang Kami</span>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none"
                            style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('about') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Profil
                                </a>
                                <a href="{{ route('team') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Tim Kami
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- SEARCH --}}
            <form method="GET" action="{{ route('jelajah') }}"
                class="hidden lg:flex items-center gap-2 flex-1 max-w-xl">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul arsip..."
                    class="w-full rounded-md px-3 py-2 text-sm">

                <select name="filter" class="rounded-md px-10 py-2 text-sm">
                    <option value="">Semua Tipe</option>

                    @foreach ($types as $type)
                        <option value="{{ $type }}" {{ request('filter') === $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                    Cari
                </button>
            </form>

            {{-- RIGHT --}}
            <div class="flex items-center gap-4">
                <x-theme-toggle />
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition">
                        Login
                    </a>
                @endauth
            </div>

        </div>
    </div>
</nav>