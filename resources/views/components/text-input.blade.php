@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 bg-white dark:bg-brand-950 text-gray-900 dark:text-gray-100 focus:border-brand-500 dark:focus:border-brand-400 focus:ring-brand-500 dark:focus:ring-brand-400 rounded-xl shadow-sm transition-colors duration-200']) }}>