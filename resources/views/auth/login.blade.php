<x-guest-layout>
    <div class="font-['Instrument_Sans'] px-2 py-2">
        
        {{-- ================= HEADER: LOGO & WELCOME ================= --}}
        <div class="flex flex-col items-center justify-center mb-8 text-center">
            
            {{-- Logo Unpak (Snippet Anda) --}}
            <div class="mb-6 scale-110">
                <a href="{{ route('welcome') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('storage/assets/Unpak.png') }}" alt="Logo Unpak" 
                         class="h-10 md:h-12 w-auto group-hover:scale-105 transition-transform duration-300 ease-in-out" />
                    <div class="flex flex-col items-start">
                        <span class="text-[9px] md:text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest leading-none mb-0.5">
                            Universitas Pakuan
                        </span>
                        <span class="text-xl md:text-2xl font-bold text-brand-600 dark:text-brand-200 leading-tight tracking-tight">
                            Digital Collection
                        </span>
                    </div>
                </a>
            </div>

            {{-- Welcome Text --}}
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                Selamat Datang Kembali
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto">
                Silakan masuk untuk mengakses arsip dan referensi akademik.
            </p>
        </div>

        {{-- ================= FORM SECTION ================= --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" class="mb-1 text-gray-700 dark:text-gray-300" />
                <div class="relative">
                    <x-text-input id="email" 
                        class="block w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-brand-25 text-gray-900 dark:text-gray-100 focus:border-brand-500 focus:ring-brand-500 shadow-sm transition-all text-sm" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required autofocus autocomplete="username" 
                        placeholder="nama@unpak.ac.id" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" class="mb-1 text-gray-700 dark:text-gray-300" />
                <x-text-input id="password" 
                    class="block w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-brand-25 text-gray-900 dark:text-gray-100 focus:border-brand-500 focus:ring-brand-500 shadow-sm transition-all text-sm"
                    type="password"
                    name="password"
                    required autocomplete="current-password" 
                    placeholder="••••••••" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" 
                           class="rounded border-gray-300 dark:border-gray-700 text-brand-600 shadow-sm focus:ring-brand-500 dark:focus:ring-brand-600 dark:bg-brand-25 cursor-pointer" 
                           name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-300 transition-colors">{{ __('Ingat saya') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-brand-600 dark:text-brand-400 hover:text-brand-800 dark:hover:text-brand-300 hover:underline transition-all" 
                       href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full justify-center py-3 text-base font-semibold rounded-xl bg-brand-600 hover:bg-brand-700 dark:bg-brand-500 dark:hover:bg-brand-400 focus:ring-4 focus:ring-brand-500/20 dark:focus:ring-brand-400/20 transition-all duration-300 shadow-lg shadow-brand-600/20">
                    {{ __('Masuk') }}
                </x-primary-button>
            </div>
            
            <div class="text-center mt-6">
                 <p class="text-xs text-gray-400 dark:text-gray-500">
                    &copy; {{ date('Y') }} Universitas Pakuan Digital Collection.
                </p>
            </div>

        </form>
    </div>
</x-guest-layout>