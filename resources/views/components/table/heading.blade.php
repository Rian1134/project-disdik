{{--
    Komponen: Table Heading
    Fungsi: Sel header tabel (<th>), dipakai di dalam slot 'head' pada <x-table>.

    Props: (tidak ada, gunakan class="text-right" dsb untuk mengatur perataan teks)

    Contoh:
    <x-slot:head>
        <x-table.heading>Nama</x-table.heading>
        <x-table.heading class="text-right">Aksi</x-table.heading>
    </x-slot:head>
--}}
@props([])

<th scope="col" {{ $attributes->class([
    'px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400',
]) }}>
    {{ $slot }}
</th>
