{{--
    Komponen: Button
    Fungsi: Tombol aksi, bisa berupa <button> (aksi/submit) atau <a> (navigasi
    ke halaman lain) — tinggal isi prop 'href' untuk yang kedua.

    Props:
    - variant  : primary | secondary | success | danger | warning | info | dark | light
                 | outline-primary | outline-secondary | outline-success | outline-danger
                 | outline-warning | outline-info | link (default: primary)
    - size     : xs | sm | md | lg | xl (default: md)
    - type     : submit | button | reset — DIABAIKAN kalau 'href' diisi (default: button)
    - href     : string, kalau diisi komponen merender <a> (link), bukan <button>
    - disabled : boolean — kalau true, SELALU merender <button disabled> walau
                 href diisi (link tidak punya konsep "disabled" secara native)
    - loading  : boolean, tampilkan spinner + otomatis disabled (cuma untuk <button>)
    - active   : boolean, tandai state aktif (data-active)
    - fullWidth: boolean, lebar penuh (w-full)
    - icon     : string HTML mentah (svg dsb), tampil di kiri teks

    Contoh tombol aksi (submit form):
    <x-button type="submit" variant="primary">Simpan</x-button>

    Contoh tombol navigasi (dulu harus dibungkus <a> manual, sekarang cukup ini):
    <x-button href="{{ route('user.show', $item->id) }}" variant="info" size="xs">
        <i class="bi bi-eye-fill"></i>
    </x-button>
--}}
@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false,
    'loading' => false,
    'active' => false,
    'fullWidth' => false,
    'icon' => null,
    'href' => null,
])

@php
    // Base classes
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    // Size variants
    $sizes = [
        'xs' => 'px-2 py-1 text-xs rounded text-sm',
        'sm' => 'px-2.5 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm rounded-md',
        'md' => 'px-3 sm:px-4 py-2 sm:py-2.5 text-sm rounded-lg',
        'lg' => 'px-4 sm:px-5 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg',
        'xl' => 'px-5 sm:px-6 py-3 sm:py-3.5 text-sm sm:text-base rounded-xl',
    ];

    // Color variants
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 active:bg-blue-800',
        'secondary' => 'bg-gray-200 text-gray-900 hover:bg-gray-300 focus:ring-gray-500 active:bg-gray-400 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600',
        'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500 active:bg-green-800',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 active:bg-red-800',
        'warning' => 'bg-yellow-500 text-white hover:bg-yellow-600 focus:ring-yellow-500 active:bg-yellow-700',
        'info' => 'bg-cyan-600 text-white hover:bg-cyan-700 focus:ring-cyan-500 active:bg-cyan-800',
        'dark' => 'bg-gray-900 text-white hover:bg-gray-800 focus:ring-gray-700 active:bg-gray-950 dark:bg-gray-800 dark:hover:bg-gray-700',
        'light' => 'bg-white text-gray-900 border border-gray-300 hover:bg-gray-50 focus:ring-gray-500 active:bg-gray-100 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700',
        'outline-primary' => 'text-blue-600 border-2 border-blue-600 hover:bg-blue-600 hover:text-white focus:ring-blue-500 active:bg-blue-700 dark:text-blue-400 dark:border-blue-400 dark:hover:bg-blue-400 dark:hover:text-white',
        'outline-secondary' => 'text-gray-600 border-2 border-gray-600 hover:bg-gray-600 hover:text-white focus:ring-gray-500 active:bg-gray-700 dark:text-gray-400 dark:border-gray-400 dark:hover:bg-gray-400',
        'outline-success' => 'text-green-600 border-2 border-green-600 hover:bg-green-600 hover:text-white focus:ring-green-500 active:bg-green-700',
        'outline-danger' => 'text-red-600 border-2 border-red-600 hover:bg-red-600 hover:text-white focus:ring-red-500 active:bg-red-700',
        'outline-warning' => 'text-yellow-600 border-2 border-yellow-600 hover:bg-yellow-600 hover:text-white focus:ring-yellow-500 active:bg-yellow-700',
        'outline-info' => 'text-cyan-600 border-2 border-cyan-600 hover:bg-cyan-600 hover:text-white focus:ring-cyan-500 active:bg-cyan-700',
        'link' => 'text-blue-600 hover:text-blue-800 focus:ring-blue-500 dark:text-blue-400 dark:hover:text-blue-300',
    ];

    // Width
    $widthClass = $fullWidth ? 'w-full' : '';

    // Combine classes
    $class = $baseClasses . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . $widthClass;

    // Loading otomatis disabled
    if ($loading) {
        $disabled = true;
    }

    // Link (<a>) cuma dipakai kalau href diisi DAN tidak disabled — <a> tidak
    // punya atribut "disabled" native, jadi state disabled selalu jatuh balik
    // ke <button disabled> supaya benar-benar tidak bisa diklik/dinavigasi.
    $asLink = filled($href) && ! $disabled;
@endphp

@if($asLink)
    <a
        href="{{ $href }}"
        {{ $attributes->class($class) }}
        @if($active) data-active @endif
    >
        @if($icon)
            <span class="mr-1 sm:mr-2">{!! $icon !!}</span>
        @endif

        <span class="truncate">{{ $slot }}</span>
    </a>
@else
    <button
        type="{{ $type }}"
        @disabled($disabled)
        {{ $attributes->merge(['class' => $class]) }}
        @if($active) data-active @endif
    >
        @if($loading)
            <svg class="animate-spin -ml-1 mr-1 sm:mr-2 h-3 w-3 sm:h-4 sm:w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @endif

        @if($icon && !$loading)
            <span class="mr-1 sm:mr-2">{!! $icon !!}</span>
        @endif

        <span class="truncate">{{ $slot }}</span>
    </button>
@endif