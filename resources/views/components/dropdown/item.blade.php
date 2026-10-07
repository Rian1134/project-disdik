@props([
    'danger' => false,
    'type' => 'button',
])

@php
    $classes = 'flex items-center w-full px-3 sm:px-4 py-2 text-sm transition-colors';
    $classes .= $danger 
        ? ' text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20' 
        : ' text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700';
@endphp

@if($type === 'button')
    <button
        type="button"
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </button>
@else
    <a
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </a>
@endif