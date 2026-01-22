<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-black leading-tight text-gray-800 dark:text-white tracking-tight">
                    {{ __('Daftar Arsip') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 uppercase tracking-widest font-bold">Total: {{ $archives->total() }} Dokumen</p>
            </div>
            <a href="{{ route('archive.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-500/20 transition-all duration-300 hover:-translate-y-1">
                <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ __('Upload Arsip Baru') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 flex items-center p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl dark:bg-emerald-900/30 dark:text-emerald-200 animate-in fade-in slide-in-from-top-4 duration-500">
                    <svg class="w-5 h-5 me-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if ($archives->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($archives as $archive)
                        <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-brand-500/10 transition-all duration-300 transform hover:-translate-y-1 flex flex-col">
                            <div class="p-6 pb-0 flex items-start justify-between">
                                <div class="p-3 bg-brand-50 dark:bg-brand-500/10 rounded-xl text-brand-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <span class="px-2.5 py-1 text-[10px] font-black uppercase rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                    ID: #{{ $archive->id }}
                                </span>
                            </div>

                            <div class="p-6 flex-grow">
                                <h3 class="font-bold text-xl text-gray-800 dark:text-white group-hover:text-brand-500 transition-colors line-clamp-1" title="{{ $archive->title }}">
                                    {{ $archive->title }}
                                </h3>
                                
                                <div class="mt-2 space-y-1">
                                    @if ($archive->creator)
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 font-medium">
                                            <svg class="w-4 h-4 me-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            {{ $archive->creator }}
                                        </div>
                                    @endif
                                    <div class="flex items-center text-xs text-gray-400 dark:text-gray-500 italic font-medium">
                                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $archive->created_at->format('d M Y') }}
                                    </div>
                                </div>

                                <div class="mt-6 pt-4 border-t border-gray-50 dark:border-gray-700 flex gap-2">
                                    <a href="{{ route('archive.show', $archive->id) }}" class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-bold bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-brand-500 hover:text-white transition-all duration-200 border border-gray-100 dark:border-gray-600">
                                        Lihat
                                    </a>
                                    <a href="{{ route('archive.edit', $archive) }}" class="inline-flex items-center justify-center px-3 py-2 text-xs font-bold bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-lg hover:bg-amber-500 hover:text-white transition-all duration-200 border border-amber-100 dark:border-amber-800/30">
                                        Edit
                                    </a>
                                    <form action="{{ route('archive.destroy', $archive) }}" method="POST" class="inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200 border border-red-100 dark:border-red-800/30" onclick="return confirm('Yakin ingin menghapus?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10 px-4 md:px-0">
                    {{ $archives->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-3xl border border-dashed border-gray-300 dark:border-gray-600">
                    <div class="p-16 flex flex-col items-center text-center">
                        <div class="w-20 h-20 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">{{ __('Belum Ada Arsip') }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 max-w-xs leading-relaxed">Sepertinya database arsip Anda masih kosong. Mulailah dengan mengunggah dokumen baru.</p>
                        <a href="{{ route('archive.create') }}" class="mt-8 px-6 py-3 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition shadow-lg shadow-brand-500/25">
                            {{ __('Upload Arsip Pertama') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>