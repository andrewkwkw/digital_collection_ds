@props(['archive', 'canEdit' => false])

<!-- Metadata -->
<div class="space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @if ($archive->creator)
        <div>
            <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Pembuat') }}</dt>
            <dd class="text-gray-600 dark:text-gray-400">{{ $archive->creator }}</dd>
        </div>
        @endif

        @if ($archive->date)
        <div>
            <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Tanggal') }}</dt>
            <dd class="text-gray-600 dark:text-gray-400">{{ $archive->date->format('d F Y') }}</dd>
        </div>
        @endif

        @if ($archive->type)
        <div>
            <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Tipe') }}</dt>
            <dd class="text-gray-600 dark:text-gray-400">{{ $archive->type }}</dd>
        </div>
        @endif

        @if ($archive->format)
        <div>
            <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Format') }}</dt>
            <dd class="text-gray-600 dark:text-gray-400">{{ $archive->format }}</dd>
        </div>
        @endif

        @if ($archive->publisher)
        <div>
            <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Penerbit') }}</dt>
            <dd class="text-gray-600 dark:text-gray-400">{{ $archive->publisher }}</dd>
        </div>
        @endif

        @if ($archive->source)
        <div>
            <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Sumber') }}</dt>
            <dd class="text-gray-600 dark:text-gray-400">{{ $archive->source }}</dd>
        </div>
        @endif
    </div>

    @if ($archive->subject)
    <div>
        <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Subjek') }}</dt>
        <dd class="text-gray-600 dark:text-gray-400">{{ $archive->subject }}</dd>
    </div>
    @endif

    @if ($archive->description)
    <div class="md:col-span-2">
        <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Deskripsi') }}</dt>
        <dd class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">
            {{ $archive->description }}
        </dd>
    </div>
    @endif

    @if ($archive->contributor)
    <div>
        <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Kontributor') }}</dt>
        <dd class="text-gray-600 dark:text-gray-400">{{ $archive->contributor }}</dd>
    </div>
    @endif

    @if ($archive->relation)
    <div>
        <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Relasi') }}</dt>
        <dd class="text-gray-600 dark:text-gray-400">{{ $archive->relation }}</dd>
    </div>
    @endif

    @if ($archive->coverage)
    <div>
        <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Cakupan') }}</dt>
        <dd class="text-gray-600 dark:text-gray-400">{{ $archive->coverage }}</dd>
    </div>
    @endif

    @if ($archive->rights)
    <div>
        <dt class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Hak Cipta') }}</dt>
        <dd class="text-gray-600 dark:text-gray-400">{{ $archive->rights }}</dd>
    </div>
    @endif
</div>