<nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 gap-6">

            {{-- LEFT --}}
            <div class="flex items-center gap-6">
                <a href="{{ route('welcome') }}" class="flex items-center gap-3">
                    <img
                        src="{{ asset('storage/assets/Unpak.png') }}"
                        alt="Logo Unpak"
                        class="h-9 w-auto" />
                    <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                        Digital Collection
                    </span>
                </a>

                <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-700 dark:text-gray-300">
                    <a href="{{ route('welcome') }}" class="hover:text-blue-600 transition">
                        Home
                    </a>
                    <a href="{{ route('jelajah') }}" class="hover:text-blue-600 transition">
                        Jelajahi
                    </a>
                    <a href="#" class="hover:text-blue-600 transition">
                        Help
                    </a>
                </div>
            </div>


            {{-- SEARCH --}}
            <form method="GET"
                action="{{ route('jelajah') }}"
                class="hidden lg:flex items-center gap-2 flex-1 max-w-xl">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul arsip..."
                    class="w-full rounded-md px-3 py-2 text-sm">

                <select name="filter" class="rounded-md px-10 py-2 text-sm">
                    <option value="">Semua Tipe</option>

                    @foreach ($types as $type)
                    <option value="{{ $type }}"
                        {{ request('filter') === $type ? 'selected' : '' }}>
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
                <a href="{{ route('login') }}">Login</a>
                @endauth
            </div>

        </div>
    </div>
</nav>