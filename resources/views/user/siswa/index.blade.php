@extends('layouts.user')

@section('title', 'Data Siswa')

@section('content')
    @if (!$sekolah)
        <div
            class="mb-4 flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 dark:border-amber-800 dark:bg-amber-900/30 dark:text-amber-200">
            <i class="bi bi-info-circle-fill mt-0.5"></i>
            <p>
                Data sekolah kamu belum diisi, jadi data siswa belum bisa ditambahkan.
                <a href="{{ route('user.sekolah.index') }}" class="font-semibold underline">Lengkapi Data Sekolah</a>
            </p>
        </div>
    @endif

    @if ($jumlahMenunggu > 0)
        <div
            class="mb-4 flex items-start gap-3 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800 dark:border-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
            <i class="bi bi-hourglass-split mt-0.5"></i>
            <p>{{ $jumlahMenunggu }} siswa hasil import sedang menunggu persetujuan admin dan belum tampil di daftar ini.
            </p>
        </div>
    @endif

    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex min-w-0 items-center gap-3">
                    <span
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-600 text-lg text-white">
                        <i class="bi bi-people-fill"></i>
                    </span>
                    <div class="min-w-0">
                        <h2 class="truncate font-semibold leading-tight">
                            {{ $sekolah ? 'Siswa ' . $sekolah->nama_sekolah : 'Data Siswa' }}
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total {{ $siswas->total() }} siswa</p>
                    </div>
                </div>
                @if ($sekolah)
                    <x-button href="{{ route('user.siswa.create') }}" size="sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Siswa
                    </x-button>
                @endif
            </div>
        </x-slot:header>

        <x-table hover class="text-sm">
            <x-slot:head>
                <tr class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                    <x-table.heading class="text-center">No</x-table.heading>
                    <x-table.heading class="min-w-56">Siswa</x-table.heading>
                    <x-table.heading class="text-center">Kelas</x-table.heading>
                    <x-table.heading class="text-center">L/P</x-table.heading>
                    <x-table.heading class="text-center">Status</x-table.heading>
                    <x-table.heading class="min-w-28 text-center">Aksi</x-table.heading>
                </tr>
            </x-slot:head>

            @forelse($siswas as $siswa)
                <x-table.row>
                    <x-table.cell class="text-center text-gray-500">{{ $siswas->firstItem() + $loop->index }}</x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-sm font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">
                                {{ mb_strtoupper(mb_substr($siswa->nama_siswa, 0, 1)) }}
                            </span>
                            <div class="min-w-0">
                                <p class="font-medium">{{ $siswa->nama_siswa }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    NISN {{ $siswa->nisn }} &middot; NIK {{ $siswa->nik }}
                                </p>
                            </div>
                        </div>
                    </x-table.cell>
                    <x-table.cell class="text-center whitespace-nowrap">{{ $siswa->kelas }}</x-table.cell>
                    <x-table.cell class="text-center">
                        <span
                            class="inline-flex h-6 w-6 items-center justify-center rounded-full text-xs font-semibold {{ $siswa->jenis_kelamin === 'L' ? 'bg-sky-50 text-sky-700 dark:bg-sky-500/15 dark:text-sky-300' : 'bg-rose-50 text-rose-700 dark:bg-rose-500/15 dark:text-rose-300' }}">
                            {{ $siswa->jenis_kelamin }}
                        </span>
                    </x-table.cell>
                    <x-table.cell class="text-center">
                        <div class="flex flex-col items-center gap-1">
                            <x-badge :variant="$siswa->status_pelajar === 'Aktif' ? 'success' : 'secondary'" pill>{{ $siswa->status_pelajar }}</x-badge>
                            @if ($siswa->isMenungguHapus())
                                <x-badge variant="warning" pill>Menunggu hapus</x-badge>
                            @endif
                        </div>
                    </x-table.cell>
                    <x-table.cell class="text-center whitespace-nowrap">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('user.siswa.show', $siswa) }}" title="Detail"
                                class="rounded-md border border-gray-200 px-2 py-1 text-sky-600 hover:bg-sky-50 dark:border-gray-700 dark:text-sky-400 dark:hover:bg-sky-500/10">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('user.siswa.edit', $siswa) }}" title="Edit"
                                class="rounded-md border border-gray-200 px-2 py-1 text-amber-600 hover:bg-amber-50 dark:border-gray-700 dark:text-amber-400 dark:hover:bg-amber-500/10">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            @if ($siswa->isMenungguHapus())
                                <span title="Pengajuan hapus menunggu admin"
                                    class="cursor-not-allowed rounded-md border border-gray-200 px-2 py-1 text-gray-400 dark:border-gray-700">
                                    <i class="bi bi-hourglass-split"></i>
                                </span>
                            @else
                                <button type="button" data-modal-open="hapus-{{ $siswa->id }}"
                                    title="{{ $siswa->isDariImport() ? 'Ajukan hapus' : 'Hapus' }}"
                                    class="rounded-md border border-gray-200 px-2 py-1 text-rose-600 hover:bg-rose-50 dark:border-gray-700 dark:text-rose-400 dark:hover:bg-rose-500/10">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            @endif
                        </div>

                        @unless ($siswa->isMenungguHapus())
                            <x-modal id="hapus-{{ $siswa->id }}" size="sm" centered>
                                <x-slot:header>{{ $siswa->isDariImport() ? 'Ajukan Penghapusan' : 'Konfirmasi Hapus' }}</x-slot:header>

                                <div class="flex flex-col items-center gap-3 text-center text-sm">
                                    <span
                                        class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-rose-50 text-xl text-rose-600 dark:bg-rose-500/15 dark:text-rose-300">
                                        <i class="bi bi-trash-fill"></i>
                                    </span>
                                    <p>
                                        @if ($siswa->isDariImport())
                                            Ajukan penghapusan <strong>{{ $siswa->nama_siswa }}</strong>?
                                            Data baru dihapus setelah disetujui admin.
                                        @else
                                            Yakin ingin menghapus <strong>{{ $siswa->nama_siswa }}</strong>?
                                        @endif
                                    </p>
                                </div>

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
                <x-table.empty colspan="6" />
            @endforelse
        </x-table>

        <x-pagination :paginator="$siswas" class="mt-4" />
    </x-card>
@endsection
