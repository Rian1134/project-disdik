@extends('layouts.user')

@section('title', 'Data Pegawai')

@section('content')
    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="font-semibold">Pegawai {{ $sekolah->nama_sekolah }}</span>
                <x-button href="{{ route('user.pegawai.create') }}" size="sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </x-button>
            </div>
        </x-slot:header>

        <x-table striped hover bordered class="text-sm">
            <x-slot:head>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <x-table.heading class="text-center">No</x-table.heading>
                    <x-table.heading class="text-center">NIP</x-table.heading>
                    <x-table.heading class="min-w-48 text-center">Nama</x-table.heading>
                    <x-table.heading class="text-center">L/P</x-table.heading>
                    <x-table.heading class="text-center">Jabatan</x-table.heading>
                    <x-table.heading class="text-center">Tugas</x-table.heading>
                    <x-table.heading class="text-center">Status Kepegawaian</x-table.heading>
                    <x-table.heading class="min-w-28 text-center">Aksi</x-table.heading>
                </tr>
            </x-slot:head>

            @forelse($pegawais as $pegawai)
                <x-table.row>
                    <x-table.cell class="text-center">{{ $pegawais->firstItem() + $loop->index }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap">{{ $pegawai->nip ?? '-' }}</x-table.cell>
                    <x-table.cell class="font-medium">{{ $pegawai->nama }}</x-table.cell>
                    <x-table.cell class="text-center">{{ $pegawai->jenis_kelamin }}</x-table.cell>
                    <x-table.cell>{{ $pegawai->jabatan }}</x-table.cell>
                    <x-table.cell>{{ $pegawai->tugas }}</x-table.cell>
                    <x-table.cell class="text-center">{{ $pegawai->status_kepegawaian }}</x-table.cell>
                    <x-table.cell class="text-center whitespace-nowrap">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('user.pegawai.show', $pegawai) }}" title="Detail"
                                class="rounded border border-gray-300 px-2 py-1 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('user.pegawai.edit', $pegawai) }}" title="Edit"
                                class="rounded border border-gray-300 px-2 py-1 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <button type="button" data-modal-open="hapus-{{ $pegawai->id }}" title="Hapus"
                                class="rounded border border-gray-300 px-2 py-1 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>

                        <x-modal id="hapus-{{ $pegawai->id }}" size="sm" centered>
                            <x-slot:header>Konfirmasi Hapus</x-slot:header>

                            <p class="text-center text-sm">
                                Yakin ingin menghapus <strong>{{ $pegawai->nama }}</strong>?
                            </p>

                            <x-slot:footer>
                                <x-button variant="light" data-modal-close>Batal</x-button>
                                <form action="{{ route('user.pegawai.destroy', $pegawai) }}" method="POST" class="inline">
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

        <x-pagination :paginator="$pegawais" class="mt-4" />
    </x-card>
@endsection
