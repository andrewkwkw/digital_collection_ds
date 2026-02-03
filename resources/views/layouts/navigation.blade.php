<nav x-data="{ open: false }"
    class="sticky top-0 z-50 bg-white/90 dark:bg-brand-25/90 backdrop-blur-md border-b border-brand-100 dark:border-gray-800 transition-colors duration-300">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 gap-4 lg:gap-8">
            
            {{-- ================= LEFT: Logo & Main Navigation ================= --}}
            <div class="flex items-center gap-8 shrink-0">
              
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('storage/assets/Unpak.png') }}" alt="Logo Unpak" 
                         class="h-8 md:h-10 w-auto group-hover:scale-105 transition-transform duration-300 ease-in-out" />
                    <div class="flex flex-col">
                        <span class="text-[8px] md:text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest leading-none mb-0.5">
                            Universitas Pakuan
                        </span>
                        <span class="text-lg md:text-xl font-bold text-brand-600 dark:text-brand-200 leading-tight tracking-tight">
                            DC Admin Panel
                        </span>
                    </div>
                </a>

                {{-- DESKTOP NAVIGATION (Pill Style) --}}
                <div class="hidden xl:flex items-center gap-1 text-sm font-medium">
                    
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.archive.index')" :active="request()->routeIs('admin.archive.*')">
                        {{ __('Arsip') }}
                    </x-nav-link>

                    @if(Auth::user()->isSuperAdmin())
                        <x-nav-link :href="route('admin.admin.index')" :active="request()->routeIs('admin.admin.*')">
                            {{ __('Daftar Admin') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.hero.index')" :active="request()->routeIs('admin.hero.*')">
                            {{ __('Hero Settings') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.team.index')" :active="request()->routeIs('admin.team.*')">
                            {{ __('Kelola Tim') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            {{-- ================= RIGHT: User Dropdown & Settings ================= --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-3">
                
                {{-- Theme Toggle --}}
                <x-theme-toggle />

                <div class="h-6 w-px bg-gray-200 dark:bg-gray-700"></div>

                {{-- User Dropdown --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 pl-1 pr-3 py-1.5 border border-transparent rounded-full hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200 focus:outline-none group">
                            <div class="h-8 w-8 rounded-full bg-brand-100 dark:bg-brand-900/50 flex items-center justify-center border border-brand-200 dark:border-brand-800">
                                <span class="text-brand-700 dark:text-brand-300 text-xs font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div class="flex flex-col items-start hidden md:flex">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-200 group-hover:text-brand-600 leading-none">{{ Auth::user()->name }}</span>
                            </div>
                            <svg class="fill-current h-4 w-4 text-gray-400 group-hover:text-brand-600 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-1">
                            {{-- Dropdown Header Mobile Only View --}}
                            <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 mb-1 md:hidden">
                                <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
                            </div>

                            <x-dropdown-link :href="route('admin.profile.edit')" class="rounded-lg">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" class="rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 dark:text-red-400"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- ================= MOBILE HAMBURGER ================= --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-brand-600 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ================= MOBILE MENU ================= --}}
    <div :class="{'block': open, 'hidden': ! open}" x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2" 
         x-transition:enter-end="opacity-100 translate-y-0"
         class="hidden sm:hidden bg-white/95 dark:bg-brand-25/95 backdrop-blur-xl border-b border-gray-100 dark:border-gray-800 shadow-xl">
        
        <div class="pt-2 pb-3 space-y-1 px-2">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.archive.index')" :active="request()->routeIs('admin.archive.*')">
                {{ __('Arsip') }}
            </x-responsive-nav-link>

            @if(Auth::user()->isSuperAdmin())
                <x-responsive-nav-link :href="route('admin.admin.index')" :active="request()->routeIs('admin.admin.*')">
                    {{ __('Daftar Admin') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.hero.index')" :active="request()->routeIs('admin.hero.*')">
                    {{ __('Hero Settings') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.team.index')" :active="request()->routeIs('admin.team.*')">
                    {{ __('Kelola Tim') }}
                </x-responsive-nav-link>
            @endif
        </div>

        {{-- Mobile User Info --}}
        <div class="pt-4 pb-4 border-t border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-black/20">
            <div class="px-4 flex items-center">
                <div class="h-10 w-10 rounded-full bg-brand-100 dark:bg-brand-900 flex items-center justify-center text-brand-600 dark:text-brand-300 font-bold border border-brand-200 dark:border-brand-700">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ms-3">
                    <div class="font-bold text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('admin.profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>