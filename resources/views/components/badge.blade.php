{{--
    Komponen: Badge
    Fungsi: Label kecil untuk status, jumlah, atau kategori.

    Props:
    - variant : primary | secondary | success | danger | warning | info | dark | light (default: primary)
    - pill    : boolean, sudut penuh membulat (default: false)
    - outline : boolean, gaya outline saja (default: false)

    Contoh:
    <x-badge variant="success">Aktif</x-badge>
    <x-badge variant="danger" pill>99+</x-badge>
    <x-badge variant="primary" outline>Baru</x-badge>
--}}
@props([
    'variant' => 'primary',
    'pill' => false,
    'outline' => false,
])

@php
    $solid = [
        'primary'   => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
        'secondary' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'success'   => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300',
        'danger'    => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
        'warning'   => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
        'info'      => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300',
        'dark'      => 'bg-gray-800 text-white dark:bg-gray-950 dark:text-gray-200',
        'light'     => 'bg-gray-50 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
    ];
    $outlineStyle = [
        'primary'   => 'border border-blue-500 text-blue-600 dark:text-blue-400',
        'secondary' => 'border border-gray-500 text-gray-600 dark:text-gray-400',
        'success'   => 'border border-emerald-500 text-emerald-600 dark:text-emerald-400',
        'danger'    => 'border border-red-500 text-red-600 dark:text-red-400',
        'warning'   => 'border border-yellow-500 text-yellow-600 dark:text-yellow-400',
        'info'      => 'border border-indigo-500 text-indigo-600 dark:text-indigo-400',
        'dark'      => 'border border-gray-800 text-gray-800 dark:text-gray-200',
        'light'     => 'border border-gray-300 text-gray-500',
    ];
    $style = $outline ? ($outlineStyle[$variant] ?? $outlineStyle['primary']) : ($solid[$variant] ?? $solid['primary']);
@endphp

<span {{ $attributes->class([
    'inline-flex items-center px-2.5 py-0.5 text-xs font-medium',
    $pill ? 'rounded-full' : 'rounded-md',
    $style,
]) }}>
    {{ $slot }}
</span>
