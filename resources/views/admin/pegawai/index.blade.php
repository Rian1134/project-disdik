@extends('layouts.admin')

@section('title', 'Data Pegawai')

@section('content')
<x-card>
    <x-slot:header>
        <div class="flex items-center justify-between gap-2">
            <span class="font-semibold">List Pegawai</span>
            <x-button href="{{ route('admin.pegawai.create') }}" size="sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah
            </x-button>
        </div>
    </x-slot:header>

    <x-table striped hover bordered class="text-sm">
        <x-slot:head>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <x-table.heading rowspan="3" class="text-center align-middle">No</x-table.heading>
                <x-table.heading colspan="2" class="text-center align-middle">Nomor</x-table.heading>
                <x-table.heading rowspan="3" class="text-center align-middle min-w-56">Nama Sekolah</x-table.heading>
                <x-table.heading colspan="11" class="text-center align-middle">Jumlah Pegawai</x-table.heading>
            </tr>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <x-table.heading rowspan="2" class="text-center align-middle">Statistik Sekolah (NSS)</x-table.heading>
                <x-table.heading rowspan="2" class="text-center align-middle">Pokok Sekolah Nasional (NPSN)</x-table.heading>
                <x-table.heading colspan="5" class="text-center align-middle">Tenaga Pendidik / Guru</x-table.heading>
                <x-table.heading colspan="5" class="text-center align-middle">Tenaga Kependidikan / Tata Usaha</x-table.heading>
                <x-table.heading rowspan="2" class="text-center align-middle">Total</x-table.heading>
            </tr>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <x-table.heading class="text-center align-middle">PNS</x-table.heading>
                <x-table.heading class="text-center align-middle">PPPK</x-table.heading>
                <x-table.heading class="text-center align-middle">PPPK Paruh Waktu</x-table.heading>
                <x-table.heading class="text-center align-middle">Honorer</x-table.heading>
                <x-table.heading class="text-center align-middle">Jumlah</x-table.heading>
                <x-table.heading class="text-center align-middle">PNS</x-table.heading>
                <x-table.heading class="text-center align-middle">PPPK</x-table.heading>
                <x-table.heading class="text-center align-middle">PPPK Paruh Waktu</x-table.heading>
                <x-table.heading class="text-center align-middle">Honorer</x-table.heading>
                <x-table.heading class="text-center align-middle">Jumlah</x-table.heading>
            </tr>
        </x-slot:head>

        @forelse($sekolahs as $sekolah)
            <x-table.row>
                <x-table.cell class="text-center">{{ $sekolahs->firstItem() + $loop->index }}</x-table.cell>
                <x-table.cell class="whitespace-nowrap">{{ $sekolah->nss }}</x-table.cell>
                <x-table.cell class="whitespace-nowrap">{{ $sekolah->npsn }}</x-table.cell>
                <x-table.cell class="font-medium">
                    <a href="{{ route('admin.pegawai.sekolah', $sekolah->id) }}" class="hover:underline">{{ $sekolah->nama_sekolah }}</a>
                </x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->guru_pns }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->guru_pppk }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->guru_paruh }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->guru_honorer }}</x-table.cell>
                <x-table.cell class="text-center font-semibold">{{ $sekolah->guru_pns + $sekolah->guru_pppk + $sekolah->guru_paruh + $sekolah->guru_honorer }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->tu_pns }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->tu_pppk }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->tu_paruh }}</x-table.cell>
                <x-table.cell class="text-center">{{ $sekolah->tu_honorer }}</x-table.cell>
                <x-table.cell class="text-center font-semibold">{{ $sekolah->tu_pns + $sekolah->tu_pppk + $sekolah->tu_paruh + $sekolah->tu_honorer }}</x-table.cell>
                <x-table.cell class="text-center font-semibold">{{ $sekolah->guru_pns + $sekolah->guru_pppk + $sekolah->guru_paruh + $sekolah->guru_honorer + $sekolah->tu_pns + $sekolah->tu_pppk + $sekolah->tu_paruh + $sekolah->tu_honorer }}</x-table.cell>
            </x-table.row>
        @empty
            <x-table.empty colspan="15" />
        @endforelse
    </x-table>

    <x-pagination :paginator="$sekolahs" class="mt-4" />
</x-card>
@endsection