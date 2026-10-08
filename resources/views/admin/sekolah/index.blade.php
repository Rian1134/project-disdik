@extends('layouts.admin')

@section('title', 'Data Sekolah')

@section('content')
<x-card>
    <x-slot:header>
        <div class="flex items-center justify-between gap-2">
            <span class="font-semibold">List Sekolah</span>
            <x-button href="{{ route('admin.sekolah.create') }}" size="sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah
            </x-button>
        </div>
    </x-slot:header>

    <x-table striped hover bordered class="text-sm">
        <x-slot:head>
            <tr class="bg-gray-100 text-center align-middle dark:bg-gray-700">
                <x-table.heading rowspan="2" class="text-center align-middle">No</x-table.heading>
                <x-table.heading colspan="2" class="text-center">Nomor</x-table.heading>
                <x-table.heading rowspan="2" class="min-w-56 text-center align-middle">Nama Sekolah</x-table.heading>
                <x-table.heading rowspan="2" class="text-center align-middle">Jumlah Tenaga Pendidik / Guru</x-table.heading>
                <x-table.heading rowspan="2" class="text-center align-middle">Jumlah Tenaga Kependidikan / TU</x-table.heading>
                <x-table.heading rowspan="2" class="text-center align-middle">Jumlah Siswa</x-table.heading>
                <x-table.heading rowspan="2" class="text-center align-middle">Status Sekolah</x-table.heading>
                <x-table.heading rowspan="2" class="text-center align-middle">Akreditasi Sekolah</x-table.heading>
                <x-table.heading rowspan="2" class="min-w-64 text-center align-middle">Alamat Sekolah</x-table.heading>
                <x-table.heading rowspan="2" class="text-center align-middle">Kecamatan</x-table.heading>
                <x-table.heading rowspan="2" class="min-w-28 text-center align-middle">Aksi</x-table.heading>
            </tr>
            <tr class="bg-gray-100 text-center dark:bg-gray-700">
                <x-table.heading class="text-center">Statistik Sekolah (NSS)</x-table.heading>
                <x-table.heading class="text-center">Pokok Sekolah Nasional (NPSN)</x-table.heading>
            </tr>
        </x-slot:head>

        @forelse($sekolahs as $sekolah)
            <x-table.row>
                <x-table.cell class="text-center">{{ $sekolahs->firstItem() + $loop->index }}</x-table.cell>
                <x-table.cell class="whitespace-nowrap">{{ $sekolah->nss }}</x-table.cell>
                <x-table.cell class="whitespace-nowrap">{{ $sekolah->npsn }}</x-table.cell>
                <x-table.cell class="font-medium">{{ $sekolah->nama_sekolah }}</x-table.cell>
                <x-table.cell class="text-center">-</x-table.cell>
                <x-table.cell class="text-center">-</x-table.cell>
                <x-table.cell class="text-center font-semibold">{{ $sekolah->siswas_count }}</x-table.cell>
                <x-table.cell class="text-center">
                    <x-badge :variant="$sekolah->status_sekolah === 'Negeri' ? 'primary' : 'warning'" pill>{{ $sekolah->status_sekolah }}</x-badge>
                </x-table.cell>
                <x-table.cell class="text-center">
                    <x-badge variant="success" pill>{{ $sekolah->akreditasi }}</x-badge>
                </x-table.cell>
                <x-table.cell>{{ $sekolah->alamat }}</x-table.cell>
                <x-table.cell>{{ $sekolah->kecamatan }}</x-table.cell>
                <x-table.cell class="text-center whitespace-nowrap">
                    <div class="inline-flex items-center gap-1">
                        <a href="{{ route('admin.sekolah.show', $sekolah) }}" title="Detail"
                            class="rounded border border-gray-300 px-2 py-1 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        <a href="{{ route('admin.sekolah.edit', $sekolah) }}" title="Edit"
                            class="rounded border border-gray-300 px-2 py-1 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <form action="{{ route('admin.sekolah.destroy', $sekolah) }}" method="POST"
                            onsubmit="return confirm('Hapus {{ $sekolah->nama_sekolah }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus"
                                class="rounded border border-gray-300 px-2 py-1 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </div>
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.empty colspan="12" />
        @endforelse
    </x-table>

    <x-pagination :paginator="$sekolahs" class="mt-4" />
</x-card>
@endsection