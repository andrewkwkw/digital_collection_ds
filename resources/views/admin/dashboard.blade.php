<x-app-layout>
    <x-slot name="header">
        {{-- Tambahkan 'w-full' agar container membentang dari kiri ke kanan --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between w-full gap-10">
            
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight">
                        {{ __('Dashboard Overview') }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Ringkasan aktivitas dan statistik arsip</p>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-white/60 dark:bg-gray-800/60 backdrop-blur-md border border-gray-200/60 dark:border-gray-700/60 rounded-full shadow-sm">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-xs font-bold text-gray-600 dark:text-gray-300 tracking-wide uppercase">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>

        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- Welcome Section --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-brand-900 to-gray-900 rounded-3xl p-8 shadow-2xl shadow-gray-200 dark:shadow-none text-white">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-5 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 rounded-full bg-brand-500 opacity-20 blur-2xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h3 class="text-3xl font-bold tracking-tight">
                            Selamat Datang, {{ Auth::user()->name }}!
                        </h3>
                        <p class="text-gray-300 mt-2 max-w-xl text-sm leading-relaxed opacity-90">
                            Sistem manajemen arsip aktif. Anda memiliki akses penuh untuk mengelola, memantau, dan mengarsipkan dokumen penting.
                        </p>
                    </div>
                    <a href="{{ route('admin.archive.create') }}" class="group whitespace-nowrap inline-flex items-center justify-center px-6 py-3 bg-white text-brand-900 font-bold text-sm rounded-xl shadow-lg hover:bg-brand-50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="bg-brand-100 p-1 rounded-md mr-3 group-hover:bg-brand-200 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        Upload Arsip Baru
                    </a>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Card 1: Total --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 dark:border-gray-700 hover:border-brand-500/30 transition-all duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Total Dokumen</p>
                            <h3 class="text-4xl font-black text-gray-900 dark:text-white mt-2">{{ $totalArchives ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-brand-50 dark:bg-brand-500/10 rounded-xl text-brand-600 dark:text-brand-400 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs font-medium text-gray-400">
                        <span class="text-emerald-500 flex items-center mr-1">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            Published
                        </span>
                    </div>
                </div>

                {{-- Card 2: Tipe --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 dark:border-gray-700 hover:border-amber-500/30 transition-all duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Variasi Tipe</p>
                            <h3 class="text-4xl font-black text-gray-900 dark:text-white mt-2">{{ $totalTypes ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-amber-50 dark:bg-amber-500/10 rounded-xl text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs font-medium text-gray-400">
                        <span>Kategori berbeda</span>
                    </div>
                </div>

                {{-- Card 3: Bulan Ini --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 dark:border-gray-700 hover:border-indigo-500/30 transition-all duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Bulan Ini</p>
                            <h3 class="text-4xl font-black text-gray-900 dark:text-white mt-2">{{ $newThisMonth ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-indigo-50 dark:bg-indigo-500/10 rounded-xl text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs font-medium text-gray-400">
                        <span class="text-indigo-500 flex items-center mr-1">
                            +{{ $newThisMonth ?? 0 }}
                        </span>
                        <span>penambahan baru</span>
                    </div>
                </div>
            </div>

            {{-- Content Split --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Recent Archives --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800">
                        <div>
                            <h4 class="font-bold text-lg text-gray-800 dark:text-white">Arsip Terbaru</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Dokumen yang baru saja ditambahkan</p>
                        </div>
                        <a href="{{ route('admin.archive.index') }}" class="group flex items-center text-xs font-bold text-brand-600 bg-brand-50 hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20 px-4 py-2 rounded-lg transition-colors">
                            Lihat Semua
                            <svg class="w-3 h-3 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] uppercase tracking-widest font-bold text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                                    <th class="px-6 py-4 font-bold">Judul Arsip</th>
                                    <th class="px-6 py-4 text-center font-bold">Tipe</th>
                                    <th class="px-6 py-4 text-right font-bold">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                                @forelse($recentArchives as $recent)
                                <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-brand-500 group-hover:bg-brand-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <span class="text-sm font-bold text-gray-700 dark:text-gray-200 group-hover:text-brand-600 dark:group-hover:text-brand-400 truncate max-w-[200px]">{{ $recent->title }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                            {{ $recent->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-xs font-medium text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300">
                                            {{ $recent->created_at->diffForHumans() }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12 mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            <span class="text-sm font-medium">Belum ada data arsip</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Distribution Chart --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 flex flex-col h-full">
                    <h4 class="font-bold text-lg text-gray-800 dark:text-white mb-2">Top 5 Kategori</h4>
                    <p class="text-xs text-gray-500 mb-6">Distribusi arsip berdasarkan tipe terbanyak</p>
                    
                    <div class="flex-1 space-y-6">
                        {{-- 
                            LOGIC FIX: Menggunakan collection method untuk sorting & limit 
                            Langsung di view agar tidak mengubah controller
                        --}}
                        @forelse($typeDistribution->sortDesc()->take(5) as $type => $count)
                        <div class="group">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-bold text-gray-700 dark:text-gray-300 group-hover:text-brand-600 transition-colors">{{ $type }}</span>
                                <div class="text-right">
                                    <span class="text-xs font-black text-gray-900 dark:text-white">{{ $count }}</span>
                                    <span class="text-[10px] text-gray-400 font-medium">file</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-brand-400 to-brand-600 h-2.5 rounded-full transition-all duration-1000 ease-out group-hover:shadow-[0_0_10px_rgba(var(--color-brand-500),0.4)] relative" 
                                     style="width: {{ ($count / max($totalArchives, 1)) * 100 }}%">
                                     <div class="absolute inset-0 bg-white/20"></div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="h-full flex flex-col items-center justify-center text-gray-400 opacity-50">
                            <span class="text-sm italic">Data distribusi kosong</span>
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center text-xs text-gray-400">
                            <span>Total Keseluruhan</span>
                            <span class="font-bold text-gray-700 dark:text-gray-300">{{ $totalArchives ?? 0 }} Arsip</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>