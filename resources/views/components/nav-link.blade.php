@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 rounded-full bg-brand-50 text-brand-700 font-semibold dark:bg-gray-800 dark:text-brand-200 text-sm transition-all duration-200 ease-in-out'
            : 'inline-flex items-center px-4 py-2 rounded-full text-gray-600 dark:text-gray-300 hover:bg-brand-50 hover:text-brand-700 dark:hover:bg-gray-800 dark:hover:text-brand-200 text-sm font-medium transition-all duration-200 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>