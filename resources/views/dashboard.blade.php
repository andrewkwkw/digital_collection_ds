<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Ringkasan Arsip') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Selamat Datang, {{ Auth::user()->name }}! 👋
                </h3>
                <p class="text-gray-600 dark:text-gray-400">Berikut adalah ringkasan sistem arsip saat ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border-b-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Arsip</p>
                            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalArchives ?? 0 }}</h3>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border-b-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Tipe Arsip</p>
                            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalTypes ?? 0 }}</h3>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg text-purple-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border-b-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Bulan Ini</p>
                            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $newThisMonth ?? 0 }}</h3>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg text-green-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-600 p-6 rounded-xl shadow-md flex items-center justify-center">
                    <a href="{{ route('archive.create') }}" class="text-white font-bold flex items-center gap-2 hover:underline">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Upload Baru
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h4 class="font-bold text-gray-700 dark:text-gray-200">Arsip Terbaru</h4>
                        <a href="{{ route('archive.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">Lihat Semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-xs uppercase">
                                <tr>
                                    <th class="px-6 py-3">Judul</th>
                                    <th class="px-6 py-3">Tipe</th>
                                    <th class="px-6 py-3">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($recentArchives as $recent)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-200">{{ $recent->title }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs bg-gray-100 dark:bg-gray-600 rounded text-gray-600 dark:text-gray-200">
                                            {{ $recent->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $recent->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-gray-500">Belum ada aktivitas upload.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border border-gray-100 dark:border-gray-700">
                    <h4 class="font-bold text-gray-700 dark:text-gray-200 mb-6 border-b pb-2">Distribusi Tipe</h4>
                    <div class="space-y-5">
                        @forelse($typeDistribution as $type => $count)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $type }}</span>
                                <span class="text-xs font-bold text-blue-600 bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 rounded-full">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ ($count / max($totalArchives, 1)) * 100 }}%"></div>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500 text-center py-4">Data tipe belum tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>