<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-brand-500/10 rounded-lg">
                <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                </svg>
            </div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Dashboard Ringkasan Arsip') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Selamat Datang, {{ Auth::user()->name }}! 👋
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Sistem manajemen arsip terpantau aman dan terkendali.</p>
                </div>
                <a href="{{ route('archive.create') }}" class="group inline-flex items-center justify-center px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/25 transition-all duration-300 hover:-translate-y-1">
                    <svg class="w-5 h-5 me-2 transform group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Upload Baru
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="relative overflow-hidden bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-brand-500/5 transition-all duration-300 group">
                    <div class="flex items-center gap-5">
                        <div class="p-4 bg-brand-50 dark:bg-brand-500/10 rounded-2xl text-brand-500 transition-colors group-hover:bg-brand-500 group-hover:text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Total Arsip</p>
                            <h3 class="text-3xl font-black text-gray-900 dark:text-white mt-1">{{ $totalArchives ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center gap-5">
                        <div class="p-4 bg-amber-50 dark:bg-amber-500/10 rounded-2xl text-amber-600 transition-colors group-hover:bg-amber-500 group-hover:text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Tipe Arsip</p>
                            <h3 class="text-3xl font-black text-gray-900 dark:text-white mt-1">{{ $totalTypes ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center gap-5">
                        <div class="p-4 bg-indigo-50 dark:bg-indigo-500/10 rounded-2xl text-indigo-600 transition-colors group-hover:bg-indigo-500 group-hover:text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Bulan Ini</p>
                            <h3 class="text-3xl font-black text-gray-900 dark:text-white mt-1">{{ $newThisMonth ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 dark:border-gray-700/50 flex justify-between items-center bg-gray-50/30 dark:bg-gray-700/10">
                        <h4 class="font-bold text-lg text-gray-800 dark:text-white">Arsip Terbaru</h4>
                        <a href="{{ route('archive.index') }}" class="text-xs font-bold bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 px-4 py-2 rounded-xl text-brand-500 hover:bg-brand-500 hover:text-white transition-all duration-300 shadow-sm">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] uppercase tracking-widest font-black text-gray-400 dark:text-gray-500 border-b border-gray-50 dark:border-gray-700">
                                    <th class="px-8 py-4">Judul Arsip</th>
                                    <th class="px-8 py-4 text-center">Tipe</th>
                                    <th class="px-8 py-4 text-right">Waktu Upload</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50 text-gray-600 dark:text-gray-300">
                                @forelse($recentArchives as $recent)
                                <tr class="group hover:bg-brand-50/40 dark:hover:bg-brand-500/5 transition-all">
                                    <td class="px-8 py-5 text-sm font-bold text-gray-800 dark:text-gray-100">{{ $recent->title }}</td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="px-3 py-1 text-[10px] font-black uppercase rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 group-hover:bg-brand-500 group-hover:text-white transition-all">
                                            {{ $recent->type }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right text-xs italic text-gray-400 dark:text-gray-500">
                                        {{ $recent->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center opacity-40">
                                            <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            <p class="text-sm">Belum ada data tersedia.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                    <h4 class="font-bold text-lg text-gray-800 dark:text-white mb-8 border-b border-gray-50 dark:border-gray-700 pb-4">Distribusi Tipe</h4>
                    <div class="space-y-8">
                        @forelse($typeDistribution as $type => $count)
                        <div class="relative">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $type }}</span>
                                <span class="text-xs font-black text-brand-600 bg-brand-500/10 px-2 py-1 rounded-md">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                <div class="bg-brand-500 h-3 rounded-full transition-all duration-1000 ease-out shadow-[0_0_10px_rgba(95,142,95,0.3)]" 
                                     style="width: {{ ($count / max($totalArchives, 1)) * 100 }}%"></div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-10 opacity-30 italic text-sm">Data kosong.</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>