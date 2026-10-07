{{--
    Komponen: Table Cell
    Fungsi: Sel data tabel (<td>), dipakai di dalam <x-table.row>.

    Props: (tidak ada, gunakan class="text-right" dsb untuk mengatur perataan teks)

    Contoh:
    <x-table.cell>{{ $user->name }}</x-table.cell>
    <x-table.cell class="text-right">
        <x-button size="xs">Edit</x-button>
    </x-table.cell>
--}}
@props([])

<td {{ $attributes->class(['px-4 py-3 text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $slot }}
</td>
