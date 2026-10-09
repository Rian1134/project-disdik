@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="font-semibold"><i class="bi bi-people-fill me-2 text-emerald-500"></i>Siswa
                    {{ $sekolah->nama_sekolah }}</span>
                <div class="flex gap-2">
                    <x-button href="{{ route('admin.siswa.index') }}" variant="light" size="sm">Kembali</x-button>
                    <x-button href="{{ route('admin.siswa.create', ['sekolah_id' => $sekolah->id]) }}" size="sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </x-button>
                </div>
            </div>
        </x-slot:header>

        <x-table striped hover bordered class="text-sm">
            <x-slot:head>
                <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
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
                    <x-table.cell
                        class="font-medium text-indigo-700 dark:text-indigo-300">{{ $siswa->nama_siswa }}</x-table.cell>
                    <x-table.cell class="text-center">{{ $siswa->kelas }}</x-table.cell>
                    <x-table.cell
                        class="text-center font-semibold {{ $siswa->jenis_kelamin === 'L' ? 'text-sky-600 dark:text-sky-300' : 'text-rose-500 dark:text-rose-300' }}">{{ $siswa->jenis_kelamin }}</x-table.cell>
                    <x-table.cell class="text-center">
                        <x-badge :variant="$siswa->status_pelajar === 'Aktif' ? 'success' : 'secondary'" pill>{{ $siswa->status_pelajar }}</x-badge>
                    </x-table.cell>
                    <x-table.cell class="text-center whitespace-nowrap">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('admin.siswa.show', $siswa) }}" title="Detail"
                                class="rounded border border-sky-200 bg-sky-50 px-2 py-1 text-sky-600 hover:bg-sky-100 dark:border-sky-500/30 dark:bg-sky-500/10 dark:text-sky-300 dark:hover:bg-sky-500/20">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('admin.siswa.edit', $siswa) }}" title="Edit"
                                class="rounded border border-amber-200 bg-amber-50 px-2 py-1 text-amber-600 hover:bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <button type="button" data-modal-open="hapus-{{ $siswa->id }}" title="Hapus"
                                class="rounded border border-rose-200 bg-rose-50 px-2 py-1 text-rose-600 hover:bg-rose-100 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300 dark:hover:bg-rose-500/20">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>

                        <x-modal id="hapus-{{ $siswa->id }}" size="sm" centered>
                            <x-slot:header><i class="bi bi-exclamation-triangle-fill me-2 text-rose-500"></i>Konfirmasi
                                Hapus</x-slot:header>

                            <p class="text-center text-sm">
                                Yakin ingin menghapus <strong>{{ $siswa->nama_siswa }}</strong>?
                            </p>

                            <x-slot:footer>
                                <x-button variant="light" data-modal-close>Batal</x-button>
                                <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" class="inline">
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
