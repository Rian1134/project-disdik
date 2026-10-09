@extends('layouts.user')

@section('title', 'Data Siswa')

@section('content')
    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="font-semibold">Siswa {{ $sekolah->nama_sekolah }}</span>
                <x-button href="{{ route('user.siswa.create') }}" size="sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </x-button>
            </div>
        </x-slot:header>

        <x-table striped hover bordered class="text-sm">
            <x-slot:head>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <x-table.heading class="text-center">No</x-table.heading>
                    <x-table.heading class="text-center">NIK</x-table.heading>
                    <x-table.heading class="text-center">NISN</x-table.heading>
                    <x-table.heading class="min-w-48 text-center">Nama Siswa</x-table.heading>
                    <x-table.heading class="text-center">Kelas</x-table.heading>
                    <x-table.heading class="text-center">L/P</x-table.heading>
                    <x-table.heading class="text-center">Status Pelajar</x-table.heading>
                    <x-table.heading class="min-w-28 text-center">Aksi</x-table.heading>
                </tr>
            </x-slot:head>

            @forelse($siswas as $siswa)
                <x-table.row>
                    <x-table.cell class="text-center">{{ $siswas->firstItem() + $loop->index }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap">{{ $siswa->nik }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap">{{ $siswa->nisn }}</x-table.cell>
                    <x-table.cell class="font-medium">{{ $siswa->nama_siswa }}</x-table.cell>
                    <x-table.cell class="text-center">{{ $siswa->kelas }}</x-table.cell>
                    <x-table.cell class="text-center">{{ $siswa->jenis_kelamin }}</x-table.cell>
                    <x-table.cell class="text-center">
                        <x-badge :variant="$siswa->status_pelajar === 'Aktif' ? 'success' : 'secondary'" pill>{{ $siswa->status_pelajar }}</x-badge>
                    </x-table.cell>
                    <x-table.cell class="text-center whitespace-nowrap">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('user.siswa.show', $siswa) }}" title="Detail"
                                class="rounded border border-gray-300 px-2 py-1 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('user.siswa.edit', $siswa) }}" title="Edit"
                                class="rounded border border-gray-300 px-2 py-1 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <button type="button" data-modal-open="hapus-{{ $siswa->id }}" title="Hapus"
                                class="rounded border border-gray-300 px-2 py-1 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>

                        <x-modal id="hapus-{{ $siswa->id }}" size="sm" centered>
                            <x-slot:header>Konfirmasi Hapus</x-slot:header>

                            <p class="text-center text-sm">
                                Yakin ingin menghapus <strong>{{ $siswa->nama_siswa }}</strong>?
                            </p>

                            <x-slot:footer>
                                <x-button variant="light" data-modal-close>Batal</x-button>
                                <form action="{{ route('user.siswa.destroy', $siswa) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger">Hapus</x-button>
                                </form>
                            </x-slot:footer>
                        </x-modal>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.empty colspan="8" />
            @endforelse
        </x-table>

        <x-pagination :paginator="$siswas" class="mt-4" />
    </x-card>
@endsection