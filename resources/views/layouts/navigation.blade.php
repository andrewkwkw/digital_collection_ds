<nav x-data="{ open: false }" class="sticky top-0 z-50 backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 border-b border-gray-200/50 dark:border-gray-800/50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="transition-transform duration-300 hover:scale-110">
                        <x-application-logo class="block h-10 w-auto fill-current text-[#5F8E5F]" />
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">

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

                    {{-- ✅ HERO SETTINGS --}}
                    <x-nav-link
                        :href="route('admin.hero.index')"
                        :active="request()->routeIs('admin.hero.*')">
                        {{ __('Hero Settings') }}
                    </x-nav-link>
                    @endif

                </div>

            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-2">
                <div class="flex items-center bg-gray-100/50 dark:bg-gray-800/50 p-1 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
                    <x-theme-toggle />

                    <div class="h-4 w-[1px] bg-gray-300 dark:bg-gray-600 mx-2"></div>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-xl text-gray-600 dark:text-gray-300 hover:text-[#5F8E5F] dark:hover:text-[#5F8E5F] transition-all duration-200 focus:outline-none">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-[#5F8E5F]/10 flex items-center justify-center me-2 border border-[#5F8E5F]/20">
                                        <span class="text-[#5F8E5F] text-xs font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    {{ Auth::user()->name }}
                                </div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="p-1">
                                <x-dropdown-link :href="route('admin.profile.edit')" class="rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        class="rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-[#5F8E5F] hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}"
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="hidden sm:hidden bg-white/90 dark:bg-gray-900/90 backdrop-blur-lg">
        <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('admin.archive.index')" :active="request()->routeIs('admin.archive.*')">
            {{ __('Arsip') }}
        </x-responsive-nav-link>

        @if(Auth::user()->isSuperAdmin())
        <x-responsive-nav-link
            :href="route('admin.admin.index')"
            :active="request()->routeIs('admin.*')">
            {{ __('Daftar Admin') }}
        </x-responsive-nav-link>

        {{-- ✅ HERO SETTINGS --}}
        <x-responsive-nav-link
            :href="route('admin.hero.index')"
            :active="request()->routeIs('admin.hero.*')">
            {{ __('Hero Settings') }}
        </x-responsive-nav-link>
        @endif


        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            <div class="px-4 flex items-center">
                <div class="h-10 w-10 rounded-full bg-[#5F8E5F] flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ms-3">
                    <div class="font-bold text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('admin.profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        class="text-red-500"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>