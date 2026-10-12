@extends('layouts.user')

@section('title', 'Data Pegawai')

@section('content')
    @if ($jumlahMenunggu > 0)
        <div
            class="mb-4 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800 dark:border-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
            <i class="bi bi-hourglass-split me-1"></i>
            {{ $jumlahMenunggu }} pegawai hasil import sedang menunggu persetujuan admin dan belum tampil di daftar ini.
        </div>
    @endif

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
                    <x-table.cell class="text-center">
                        {{ $pegawai->status_kepegawaian }}
                        @if ($pegawai->isMenungguHapus())
                            <x-badge variant="warning" pill>Menunggu hapus</x-badge>
                        @endif
                    </x-table.cell>
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
                            @if ($pegawai->isMenungguHapus())
                                <span title="Pengajuan hapus menunggu admin"
                                    class="cursor-not-allowed rounded border border-gray-200 px-2 py-1 text-gray-400 dark:border-gray-700">
                                    <i class="bi bi-hourglass-split"></i>
                                </span>
                            @else
                                <button type="button" data-modal-open="hapus-{{ $pegawai->id }}"
                                    title="{{ $pegawai->isDariImport() ? 'Ajukan hapus' : 'Hapus' }}"
                                    class="rounded border border-gray-300 px-2 py-1 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            @endif
                        </div>

                        @unless ($pegawai->isMenungguHapus())
                            <x-modal id="hapus-{{ $pegawai->id }}" size="sm" centered>
                                <x-slot:header>{{ $pegawai->isDariImport() ? 'Ajukan Penghapusan' : 'Konfirmasi Hapus' }}</x-slot:header>

                                <p class="text-center text-sm">
                                    @if ($pegawai->isDariImport())
                                        Ajukan penghapusan <strong>{{ $pegawai->nama }}</strong>?
                                        Data baru dihapus setelah disetujui admin.
                                    @else
                                        Yakin ingin menghapus <strong>{{ $pegawai->nama }}</strong>?
                                    @endif
                                </p>

                                <x-slot:footer>
                                    <x-button variant="light" data-modal-close>Batal</x-button>
                                    <form action="{{ route('user.pegawai.destroy', $pegawai) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit"
                                            variant="danger">{{ $pegawai->isDariImport() ? 'Ajukan' : 'Hapus' }}</x-button>
                                    </form>
                                </x-slot:footer>
                            </x-modal>
                        @endunless
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.empty colspan="8" />
            @endforelse
        </x-table>

        <x-pagination :paginator="$pegawais" class="mt-4" />
    </x-card>
@endsection
