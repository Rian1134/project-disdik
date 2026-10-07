{{--
    Komponen: List Group
    Fungsi: Daftar item vertikal dalam kotak, mendukung link dan status aktif.

    Props: (tidak ada, gunakan slot berisi elemen dengan class list-group-item)

    Contoh:
    <x-list-group>
        <a href="#" class="list-group-item active">Item Aktif</a>
        <a href="#" class="list-group-item">Item Biasa</a>
        <a href="#" class="list-group-item">Item Lain</a>
    </x-list-group>
--}}
@props([])

<div {{ $attributes->class([
    'flex flex-col divide-y divide-gray-200 dark:divide-gray-700',
    'rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden bg-white dark:bg-gray-800',
]) }}>
    {{ $slot }}
</div>
