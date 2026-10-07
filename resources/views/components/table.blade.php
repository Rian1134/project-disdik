{{--
    Komponen: Table
    Fungsi: Menampilkan data tabular dengan header (termasuk header berlapis/rowspan-colspan),
            body, tfoot ringkasan, hover, striped, dan responsive (scroll horizontal otomatis
            di layar kecil).

    Props:
    - striped : boolean, baris body bergantian warna (default: false)
    - hover   : boolean, highlight baris body saat kursor di atasnya (default: true)
    - bordered: boolean, tambahkan garis antar kolom (default: false)

    Slot bernama:
    - head  : isi <thead>. Tulis <tr> sendiri (boleh lebih dari satu baris untuk header
              berlapis dengan rowspan/colspan) berisi <x-table.heading> atau <th> manual.
    - $slot : isi <tbody>. Gunakan <x-table.row>/<x-table.cell>, atau <tr>/<td> manual.
    - foot  : (opsional) isi <tfoot>. Tulis <tr> sendiri, biasanya untuk baris total/ringkasan.

    Untuk kondisi data kosong, gunakan <x-table.empty colspan="{{ $jumlahKolom }}" />
    sebagai satu-satunya baris di dalam $slot.

    Contoh sederhana (header 1 baris):
    <x-table striped hover>
        <x-slot:head>
            <tr>
                <x-table.heading>Nama</x-table.heading>
                <x-table.heading>Email</x-table.heading>
                <x-table.heading class="text-right">Aksi</x-table.heading>
            </tr>
        </x-slot:head>

        @forelse($users as $user)
            <x-table.row>
                <x-table.cell>{{ $user->name }}</x-table.cell>
                <x-table.cell>{{ $user->email }}</x-table.cell>
                <x-table.cell class="text-right">
                    <x-button size="xs" variant="outline-primary">Edit</x-button>
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.empty colspan="3" />
        @endforelse
    </x-table>

    Contoh header berlapis (rowspan/colspan) + tfoot:
    <x-table bordered>
        <x-slot:head>
            <tr>
                <x-table.heading rowspan="2">Nama</x-table.heading>
                <x-table.heading colspan="2" class="text-center">Nilai</x-table.heading>
            </tr>
            <tr>
                <x-table.heading class="text-center">UTS</x-table.heading>
                <x-table.heading class="text-center">UAS</x-table.heading>
            </tr>
        </x-slot:head>

        ...baris body...

        <x-slot:foot>
            <tr>
                <x-table.cell class="font-bold">Total</x-table.cell>
                <x-table.cell class="text-center font-bold" colspan="2">100</x-table.cell>
            </tr>
        </x-slot:foot>
    </x-table>

    <x-pagination :paginator="$users" class="mt-4" />
--}}
@props([
    'striped' => false,
    'hover' => true,
    'bordered' => false,
])

<div class="w-full overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
    <table {{ $attributes->class(['w-full text-sm text-left', $bordered ? 'border-collapse' : '']) }}>
        @isset($head)
            <thead class="bg-gray-50 dark:bg-gray-800">
                {{ $head }}
            </thead>
        @endisset

        <tbody
            class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800"
            data-table-striped="{{ $striped ? 'true' : 'false' }}"
            data-table-hover="{{ $hover ? 'true' : 'false' }}"
        >
            {{ $slot }}
        </tbody>

        @isset($foot)
            <tfoot class="bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                {{ $foot }}
            </tfoot>
        @endisset
    </table>
</div>
