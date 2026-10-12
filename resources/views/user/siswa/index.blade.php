@extends('layouts.user')

@section('title', 'Data Siswa')

@section('content')
    @if (!$sekolah)
        <div
            class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 dark:border-amber-800 dark:bg-amber-900/30 dark:text-amber-200">
            <i class="bi bi-info-circle-fill me-1"></i>
            Data sekolah kamu belum diisi, jadi data siswa belum bisa ditambahkan.
            <a href="{{ route('user.sekolah.index') }}" class="font-semibold underline">Lengkapi Data Sekolah</a>
        </div>
    @endif

    @if ($jumlahMenunggu > 0)
        <div
            class="mb-4 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800 dark:border-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
            <i class="bi bi-hourglass-split me-1"></i>
            {{ $jumlahMenunggu }} siswa hasil import sedang menunggu persetujuan admin dan belum tampil di daftar ini.
        </div>
    @endif

    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="font-semibold">
                    {{ $sekolah ? 'Siswa ' . $sekolah->nama_sekolah : 'Data Siswa' }}
                </span>
                @if ($sekolah)
                    <x-button href="{{ route('user.siswa.create') }}" size="sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </x-button>
                @endif
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
                        @if ($siswa->isMenungguHapus())
                            <x-badge variant="warning" pill>Menunggu hapus</x-badge>
                        @endif
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
                            @if ($siswa->isMenungguHapus())
                                <span title="Pengajuan hapus menunggu admin"
                                    class="cursor-not-allowed rounded border border-gray-200 px-2 py-1 text-gray-400 dark:border-gray-700">
                                    <i class="bi bi-hourglass-split"></i>
                                </span>
                            @else
                                <button type="button" data-modal-open="hapus-{{ $siswa->id }}"
                                    title="{{ $siswa->isDariImport() ? 'Ajukan hapus' : 'Hapus' }}"
                                    class="rounded border border-gray-300 px-2 py-1 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            @endif
                        </div>

                        @unless ($siswa->isMenungguHapus())
                            <x-modal id="hapus-{{ $siswa->id }}" size="sm" centered>
                                <x-slot:header>{{ $siswa->isDariImport() ? 'Ajukan Penghapusan' : 'Konfirmasi Hapus' }}</x-slot:header>

                                <p class="text-center text-sm">
                                    @if ($siswa->isDariImport())
                                        Ajukan penghapusan <strong>{{ $siswa->nama_siswa }}</strong>?
                                        Data baru dihapus setelah disetujui admin.
                                    @else
                                        Yakin ingin menghapus <strong>{{ $siswa->nama_siswa }}</strong>?
                                    @endif
                                </p>

                                <x-slot:footer>
                                    <x-button variant="light" data-modal-close>Batal</x-button>
                                    <form action="{{ route('user.siswa.destroy', $siswa) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit"
                                            variant="danger">{{ $siswa->isDariImport() ? 'Ajukan' : 'Hapus' }}</x-button>
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

        <x-pagination :paginator="$siswas" class="mt-4" />
    </x-card>
@endsection
