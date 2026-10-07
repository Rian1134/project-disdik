{{--
    Komponen: Table Row
    Fungsi: Baris tabel (<tr>), dipakai di dalam $slot pada <x-table>.
            Otomatis mengikuti style hover/striped dari <x-table> induk (via CSS
            selector data-table-striped/data-table-hover di components.css).

    Props: (tidak ada)

    Contoh:
    <x-table.row>
        <x-table.cell>Budi</x-table.cell>
        <x-table.cell>budi@email.com</x-table.cell>
    </x-table.row>
--}}
@props([])

<tr {{ $attributes->class(['transition-colors']) }}>
    {{ $slot }}
</tr>
