@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<x-card>
    <x-slot:header>
        <span class="font-semibold">List Siswa</span>
    </x-slot:header>

    <x-table striped hover bordered class="text-sm">
        <x-slot:head>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <x-table.heading rowspan="3" class="text-center align-middle">No</x-table.heading>
                <x-table.heading colspan="2" class="text-center align-middle">Nomor</x-table.heading>
                <x-table.heading rowspan="3" class="min-w-56 text-center align-middle">Nama Sekolah</x-table.heading>
                <x-table.heading colspan="16" class="text-center align-middle">Jumlah Siswa</x-table.heading>
            </tr>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <x-table.heading rowspan="2" class="text-center align-middle">Statistik Sekolah (NSS)</x-table.heading>
                <x-table.heading rowspan="2" class="text-center align-middle">Pokok Sekolah Nasional (NPSN)</x-table.heading>
                <x-table.heading colspan="4" class="text-center align-middle">Kelas VII</x-table.heading>
                <x-table.heading colspan="4" class="text-center align-middle">Kelas VIII</x-table.heading>
                <x-table.heading colspan="4" class="text-center align-middle">Kelas IX</x-table.heading>
                <x-table.heading colspan="4" class="text-center align-middle">Jumlah Seluruh</x-table.heading>
            </tr>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <x-table.heading class="text-center align-middle">Rombel</x-table.heading>
                <x-table.heading class="text-center align-middle">L</x-table.heading>
                <x-table.heading class="text-center align-middle">P</x-table.heading>
                <x-table.heading class="text-center align-middle">Jlh</x-table.heading>
                <x-table.heading class="text-center align-middle">Rombel</x-table.heading>
                <x-table.heading class="text-center align-middle">L</x-table.heading>
                <x-table.heading class="text-center align-middle">P</x-table.heading>
                <x-table.heading class="text-center align-middle">Jlh</x-table.heading>
                <x-table.heading class="text-center align-middle">Rombel</x-table.heading>
                <x-table.heading class="text-center align-middle">L</x-table.heading>
                <x-table.heading class="text-center align-middle">P</x-table.heading>
                <x-table.heading class="text-center align-middle">Jlh</x-table.heading>
                <x-table.heading class="text-center align-middle">Rombel</x-table.heading>
                <x-table.heading class="text-center align-middle">L</x-table.heading>
                <x-table.heading class="text-center align-middle">P</x-table.heading>
                <x-table.heading class="text-center align-middle">Siswa</x-table.heading>
            </tr>
        </x-slot:head>

        @forelse($sekolahs as $sekolah)
            <x-table.row>
                <x-table.cell class="text-center">{{ $sekolahs->firstItem() + $loop->index }}</x-table.cell>
                <x-table.cell class="whitespace-nowrap">{{ $sekolah->nss }}</x-table.cell>
                <x-table.cell class="whitespace-nowrap">{{ $sekolah->npsn }}</x-table.cell>
                <x-table.cell class="font-medium">{{ $sekolah->nama_sekolah }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->vii_rombel }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->vii_l }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->vii_p }}</x-table.cell>
                <x-table.cell class="text-center font-semibold">{{ $sekolah->vii_l + $sekolah->vii_p }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->viii_rombel }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->viii_l }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->viii_p }}</x-table.cell>
                <x-table.cell class="text-center font-semibold">{{ $sekolah->viii_l + $sekolah->viii_p }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->ix_rombel }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->ix_l }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->ix_p }}</x-table.cell>
                <x-table.cell class="text-center font-semibold">{{ $sekolah->ix_l + $sekolah->ix_p }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->total_rombel }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->total_l }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->total_p }}</x-table.cell>
                <x-table.cell class="text-center font-semibold">{{ $sekolah->total_l + $sekolah->total_p }}</x-table.cell>
            </x-table.row>
        @empty
            <x-table.empty colspan="20" />
        @endforelse
    </x-table>

    <x-pagination :paginator="$sekolahs" class="mt-4" />
</x-card>
@endsection