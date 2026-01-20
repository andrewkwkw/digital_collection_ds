<nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="{{ route('welcome') }}" class="text-xl font-bold text-blue-600 dark:text-blue-400">
                    {{ config('app.name', 'Digital Collection') }}
                </a>
            </div>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('welcome') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">
                    {{ __('Home') }}
                </a>
                <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">
                    {{ __('Help') }}
                </a>
            </div>
            
            <div class="flex items-center gap-4">
                <x-theme-toggle />
                @if (Route::has('login'))
                @auth
                <a
                    href="{{ url('/dashboard') }}"
                    class="px-4 py-2 text-blue-600 dark:text-blue-400 border border-blue-600 dark:border-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900 transition">
                    {{ __('Dashboard') }}
                </a>
                @else
                <a
                    href="{{ route('login') }}"
                    class="px-4 py-2 text-blue-600 dark:text-blue-400 border border-blue-600 dark:border-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900 transition">
                    {{ __('Login') }}
                </a>
                @endauth
                @endif
            </div>
        </div>
    </div>
</nav>