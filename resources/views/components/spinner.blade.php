{{--
    Komponen: Spinner
    Fungsi: Indikator loading berputar.

    Props:
    - size  : xs | sm | md | lg | xl (default: md)
    - color : primary | secondary | success | danger | warning | info | light | dark (default: primary)

    Contoh:
    <x-spinner size="lg" color="primary" />
--}}
@props([
    'size' => 'md',
    'color' => 'primary',
])

@php
    $sizes = [
        'xs' => 'h-3 w-3 border-2',
        'sm' => 'h-4 w-4 border-2',
        'md' => 'h-6 w-6 border-2',
        'lg' => 'h-8 w-8 border-[3px]',
        'xl' => 'h-12 w-12 border-4',
    ];
    $colors = [
        'primary'   => 'border-blue-600 border-t-transparent',
        'secondary' => 'border-gray-600 border-t-transparent',
        'success'   => 'border-emerald-600 border-t-transparent',
        'danger'    => 'border-red-600 border-t-transparent',
        'warning'   => 'border-yellow-500 border-t-transparent',
        'info'      => 'border-indigo-500 border-t-transparent',
        'light'     => 'border-gray-200 border-t-transparent',
        'dark'      => 'border-gray-800 border-t-transparent',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $colorClass = $colors[$color] ?? $colors['primary'];
@endphp

<span
    {{ $attributes->class(['inline-block animate-spin rounded-full', $sizeClass, $colorClass]) }}
    role="status"
    aria-label="Memuat"
></span>
