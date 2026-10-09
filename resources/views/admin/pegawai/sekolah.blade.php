@extends('layouts.admin')

@section('title', 'Data Pegawai')

@section('content')
    @php
        $warnaStatus = [
            'PNS' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
            'PPPK' => 'bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-300',
            'PPPK Paruh Waktu' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-300',
            'Non-ASN' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
            'Honorer' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-300',
        ];
        $warnaStatusLain = 'bg-slate-100 text-slate-600 dark:bg-slate-500/20 dark:text-slate-300';
    @endphp
    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="font-semibold"><i class="bi bi-person-badge-fill me-2 text-amber-500"></i>Pegawai
                    {{ $sekolah->nama_sekolah }}</span>
                <div class="flex gap-2">
                    <x-button href="{{ route('admin.pegawai.index') }}" variant="light" size="sm">Kembali</x-button>
                    <x-button href="{{ route('admin.pegawai.create', ['sekolah_id' => $sekolah->id]) }}" size="sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </x-button>
                </div>
            </div>
        </x-slot:header>

        <x-table striped hover bordered class="text-sm">
            <x-slot:head>
                <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
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
                    <x-table.cell class="whitespace-nowrap">{{ $pegawai->nip ?: '-' }}</x-table.cell>
                    <x-table.cell
                        class="font-medium text-indigo-700 dark:text-indigo-300">{{ $pegawai->nama }}</x-table.cell>
                    <x-table.cell
                        class="text-center font-semibold {{ $pegawai->jenis_kelamin === 'L' ? 'text-sky-600 dark:text-sky-300' : 'text-rose-500 dark:text-rose-300' }}">{{ $pegawai->jenis_kelamin }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap text-center">
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $pegawai->jabatan === 'Tenaga Pendidik' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300' }}">{{ $pegawai->jabatan }}</span>
                    </x-table.cell>
                    <x-table.cell>{{ $pegawai->tugas }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap text-center">
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $warnaStatus[$pegawai->status_kepegawaian] ?? $warnaStatusLain }}">{{ $pegawai->status_kepegawaian }}</span>
                    </x-table.cell>
                    <x-table.cell class="text-center whitespace-nowrap">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('admin.pegawai.show', $pegawai) }}" title="Detail"
                                class="rounded border border-sky-200 bg-sky-50 px-2 py-1 text-sky-600 hover:bg-sky-100 dark:border-sky-500/30 dark:bg-sky-500/10 dark:text-sky-300 dark:hover:bg-sky-500/20">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('admin.pegawai.edit', $pegawai) }}" title="Edit"
                                class="rounded border border-amber-200 bg-amber-50 px-2 py-1 text-amber-600 hover:bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <button type="button" data-modal-open="hapus-{{ $pegawai->id }}" title="Hapus"
                                class="rounded border border-rose-200 bg-rose-50 px-2 py-1 text-rose-600 hover:bg-rose-100 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300 dark:hover:bg-rose-500/20">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>

                        <x-modal id="hapus-{{ $pegawai->id }}" size="sm" centered>
                            <x-slot:header><i class="bi bi-exclamation-triangle-fill me-2 text-rose-500"></i>Konfirmasi
                                Hapus</x-slot:header>

                            <p class="text-center text-sm">
                                Yakin ingin menghapus <strong>{{ $pegawai->nama }}</strong>?
                            </p>

                            <x-slot:footer>
                                <x-button variant="light" data-modal-close>Batal</x-button>
                                <form action="{{ route('admin.pegawai.destroy', $pegawai) }}" method="POST"
                                    class="inline">
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
